from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.chrome.service import Service
import time

# ✅ Set the path to your local chromedriver
chromedriver_path = r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe"
service = Service(chromedriver_path)
driver = webdriver.Chrome(service=service)

# Open the customer parcel page
driver.get("http://localhost/Railway_Storage_Management_System/customer_parcel.php")
driver.maximize_window()

# Fill out the form fields
driver.find_element(By.ID, "id").send_keys("4321")
driver.find_element(By.ID, "sender_id").send_keys("911112223V")
driver.find_element(By.ID, "receiver_id").send_keys("922223334V")
driver.find_element(By.ID, "receiver").send_keys("Alice Smith")
driver.find_element(By.ID, "tel").send_keys("0771234567")
driver.find_element(By.ID, "date").send_keys("2024-05-16")  # Use current or valid date
driver.find_element(By.ID, "pickup").send_keys("Matale")
driver.find_element(By.ID, "drop").send_keys("Colombo")
driver.find_element(By.ID, "weight").send_keys("3.2")  # Triggers JS calculation of pay

# Wait briefly to ensure JS updates "pay" field
time.sleep(1)

# Check auto-calculated payment
pay_value = driver.find_element(By.ID, "pay").get_attribute("value")
assert pay_value == "160.00", f"❌ Payment calculation incorrect. Got {pay_value}"

# Select status from dropdown
Select(driver.find_element(By.ID, "status")).select_by_value("ready_for_dispatch")

# Submit the form
submit_button = driver.find_element(By.NAME, "create")
submit_button.click()

# Wait a bit to observe post-submission behavior
time.sleep(2)

# Optionally, take a screenshot of result
driver.save_screenshot("parcel_submission_result.png")

# Close browser
driver.quit()
