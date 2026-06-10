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

def test_login(driver):
    login_url = "http://127.0.0.1:8000/login"
    email = "admin@gosheep.test"
    password = "password"

    driver.get(login_url)
    time.sleep(3)
    
    email_field = driver.find_element(By.NAME, "email")
    password_field = driver.find_element(By.NAME, "password")
    login_button = driver.find_element(By.XPATH, '//button[@type="submit"]')
    
    email_field.send_keys(email)
    time.sleep(2)
    password_field.send_keys(password)
    time.sleep(2)
    login_button.click()
    time.sleep(4)
    
    assert "login" not in driver.current_url, "Login Gagal: masih di halaman login"
    print("Login Berhasil, pindah ke:", driver.current_url)
    
    
    tombol_logout = driver.find_element(By.XPATH, '//button[@title="Keluar Sistem"]')
    tombol_logout.click()
    time.sleep(2)
    
    tombol_konfirmasi = driver.find_element(By.CLASS_NAME, "swal2-confirm")
    tombol_konfirmasi.click()
    time.sleep(3)
    
    assert "login" in driver.current_url, "Logout Gagal: belum kembali ke halaman login"
    print("Logout Berhasil: kembali ke:", driver.current_url)