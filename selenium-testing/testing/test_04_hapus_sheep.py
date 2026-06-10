import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
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


def test_hapus_sheep(driver):
    login(driver)

    menu_domba = driver.find_element(By.XPATH, '//aside//a[contains(., "Ternak Domba")]')
    menu_domba.click()
    time.sleep(2)

    tombol_hapus = driver.find_element(
        By.XPATH, '//tr[contains(., "TEST-001")]//form[contains(@class, "delete-form")]//button'
    )
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", tombol_hapus)
    time.sleep(1)
    tombol_hapus.click()
    time.sleep(2)

    tombol_konfirmasi = driver.find_element(By.CLASS_NAME, "swal2-confirm")
    tombol_konfirmasi.click()
    time.sleep(3)

    try:
        driver.find_element(By.CLASS_NAME, "swal2-confirm").click()
        time.sleep(2)
    except:
        pass

    assert "TEST-001" not in driver.page_source, \
        "Hapus domba GAGAL: data TEST-001 masih ada di halaman"
    print("Hapus domba BERHASIL, data TEST-001 sudah tidak ada")