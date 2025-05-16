from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

driver_path = r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe"
service = Service(executable_path=driver_path)
driver = webdriver.Chrome(service=service)

driver.get("http://localhost/Railway_Storage_Management_System/register.php")

# Fill out form fields
driver.find_element(By.ID, "role").send_keys("customer")
driver.find_element(By.ID, "Cus_NIC").send_keys("123456789")
driver.find_element(By.ID, "Cus_Name").send_keys("Test Customer")
driver.find_element(By.ID, "Cus_TP").send_keys("0771234567")
driver.find_element(By.ID, "email").send_keys("testcustomer@example.com")
driver.find_element(By.ID, "password").send_keys("TestPass123..")
driver.find_element(By.ID, "password_confirmation").send_keys("TestPass123..")

# Submit form by locating the button by name
driver.find_element(By.NAME, "register").click()

try:
    WebDriverWait(driver, 10).until(EC.url_contains("login.php"))
    print("Registration successful and redirected to login page.")
except Exception as e:
    print("Registration may have failed or redirection issue:", e)

time.sleep(5)
driver.quit()
