import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time


@pytest.fixture(scope="module")
def driver():
    driver = webdriver.Chrome()
    driver.maximize_window()
    yield driver
    driver.quit()


def login(driver):
    driver.get("http://127.0.0.1:8000/login")
    time.sleep(2)
    driver.find_element(By.NAME, "email").send_keys("admin@gosheep.test")
    driver.find_element(By.NAME, "password").send_keys("password")
    driver.find_element(By.XPATH, '//button[@type="submit"]').click()
    time.sleep(3)
    try:
        driver.find_element(By.CLASS_NAME, "swal2-confirm").click()
        time.sleep(2)
    except:
        pass


def test_ubah_sheep(driver):
    login(driver)

    menu_domba = driver.find_element(By.XPATH, '//aside//a[contains(., "Ternak Domba")]')
    menu_domba.click()
    time.sleep(2)

    tombol_edit = driver.find_element(By.XPATH, '//tr[contains(., "TEST-001")]//a[contains(@href, "/edit")]')
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", tombol_edit)
    time.sleep(1)
    tombol_edit.click()
    time.sleep(2)

    eartag = driver.find_element(By.NAME, "eartag")
    eartag.clear()
    eartag.send_keys("TEST-001-EDIT")
    time.sleep(1)

    Select(driver.find_element(By.NAME, "status")).select_by_value("sold")
    time.sleep(1)

    tombol_simpan = driver.find_element(By.XPATH, '//button[contains(., "Simpan Perubahan")]')
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", tombol_simpan)
    time.sleep(1)
    tombol_simpan.click()
    time.sleep(0.5)

    try:
        driver.find_element(By.CLASS_NAME, "swal2-confirm").click()
        time.sleep(3)
    except:
        pass

    assert "/sheep" in driver.current_url and "edit" not in driver.current_url, \
        "Ubah domba GAGAL: tidak kembali ke halaman daftar"
    print("Ubah domba BERHASIL, sekarang di:", driver.current_url)