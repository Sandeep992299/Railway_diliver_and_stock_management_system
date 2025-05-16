from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.service import Service
import time

# ✅ Set your actual chromedriver path here
chromedriver_path = r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe"
service = Service(executable_path=chromedriver_path)

driver = webdriver.Chrome(service=service)
driver.get("http://localhost/Railway_Storage_Management_System/parcel_t.php")  # Adjust URL as needed

time.sleep(5)  # Wait for page to load

# Search
search_input = driver.find_element(By.NAME, "search")
search_input.send_keys("Colombo")
search_input.send_keys(Keys.RETURN)

time.sleep(3)  # Wait for results

# Check that data is loaded
table = driver.find_element(By.TAG_NAME, "table")
rows = table.find_elements(By.TAG_NAME, "tr")

assert len(rows) > 1, "No search results found!"

print("✅ Test passed: Search results loaded")

driver.quit()
