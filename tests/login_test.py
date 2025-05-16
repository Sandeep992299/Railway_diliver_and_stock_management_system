from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select, WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# ✅ Path to your ChromeDriver
service = Service(r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe")
driver = webdriver.Chrome(service=service)

try:
    # Open the login page
    driver.get("http://localhost/Railway_Storage_Management_System/login.php")  # ✅ Replace if needed

    # Wait for the userType dropdown to be visible
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "userType")))

    # Select user type (e.g., "user" or "employee")
    select = Select(driver.find_element(By.NAME, "userType"))
    select.select_by_value("employee")  # Change to "employee" if needed

    # Fill in credentials
    driver.find_element(By.NAME, "email").send_keys("dinura.sen25@gmail.com")
    driver.find_element(By.NAME, "password").send_keys("dinura123..")

    # Click the login button
    driver.find_element(By.NAME, "submit").click()

    # Wait for redirect or error
    time.sleep(2)
    current_url = driver.current_url

    if "verify.php" in current_url:
        print("✅ Login successful, redirected to OTP page.")
    else:
        errors = driver.find_elements(By.CLASS_NAME, "error-msg")
        if errors:
            for error in errors:
                print("❌ Login failed with message:", error.text)
        else:
            print("❌ Login failed. No specific error message found.")

finally:
    driver.quit()
