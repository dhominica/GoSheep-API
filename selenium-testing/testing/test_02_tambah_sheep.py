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
    
    try:
        driver.find_element(By.CLASS_NAME, "swal2-confirm").click()
        time.sleep(0.5)
    except:
        pass


def login(driver):
    driver.get("http://127.0.0.1:8000/login")
    time.sleep(2)
    driver.find_element(By.NAME, "email").send_keys("admin@gosheep.test")
    driver.find_element(By.NAME, "password").send_keys("password")
    driver.find_element(By.XPATH, '//button[@type="submit"]').click()
    time.sleep(3)


def test_tambah_sheep(driver):
    login(driver)

    menu_domba = driver.find_element(By.XPATH, '//aside//a[contains(., "Ternak Domba")]')
    menu_domba.click()
    time.sleep(2)

    tombol_tambah = driver.find_element(By.XPATH, '//a[contains(., "Tambah Domba")]')
    tombol_tambah.click()
    time.sleep(2)

    driver.find_element(By.NAME, "eartag").send_keys("TEST-001")
    time.sleep(1)
    Select(driver.find_element(By.NAME, "eartag_color")).select_by_value("red")
    time.sleep(1)
    Select(driver.find_element(By.NAME, "gender")).select_by_value("male")
    time.sleep(1)
    birth_date = driver.find_element(By.NAME, "birth_date")
    driver.execute_script("arguments[0].value = '2024-06-15';", birth_date)
    time.sleep(1)
    Select(driver.find_element(By.NAME, "status")).select_by_value("active")
    time.sleep(1)

    Select(driver.find_element(By.NAME, "breed_id")).select_by_index(1)
    time.sleep(1)
    Select(driver.find_element(By.NAME, "cage_id")).select_by_index(1)
    time.sleep(1)
    Select(driver.find_element(By.NAME, "sire_id")).select_by_index(1)
    time.sleep(1)
    Select(driver.find_element(By.NAME, "dam_id")).select_by_index(1)
    time.sleep(1)

    driver.find_element(By.NAME, "weight").send_keys("25")
    time.sleep(1)
    Select(driver.find_element(By.NAME, "category")).select_by_value("health")
    time.sleep(1)
    Select(driver.find_element(By.NAME, "severity")).select_by_value("normal")
    time.sleep(1)
    driver.find_element(By.NAME, "condition").send_keys("Sehat, nafsu makan baik")
    time.sleep(1)

    tombol_simpan = driver.find_element(By.XPATH, '//button[contains(., "Simpan Data Domba")]')
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", tombol_simpan)
    time.sleep(1)
    tombol_simpan.click()
    time.sleep(0.5)
    
    tombol_ok = driver.find_element(By.CLASS_NAME, "swal2-confirm")
    tombol_ok.click()
    time.sleep(3)

    assert "/sheep" in driver.current_url and "create" not in driver.current_url, \
        "Tambah domba GAGAL: tidak kembali ke halaman daftar (kemungkinan validasi gagal)"
    print("Tambah domba BERHASIL, sekarang di:", driver.current_url)