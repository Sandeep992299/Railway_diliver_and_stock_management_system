from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.keys import Keys
import time

# Path to your downloaded ChromeDriver
chrome_driver_path = "C:/Users/USER/Downloads/chromedriver-win64/chromedriver.exe"

# Setup ChromeDriver with service
service = Service(chrome_driver_path)
driver = webdriver.Chrome(service=service)

driver.maximize_window()
driver.get("http://localhost/Railway_Storage_Management_System/main.php")  # Update URL as needed

try:
    # Check Title
    assert "Kandy Railway Station" in driver.title
    print("Page title loaded successfully.")

    # Test Sidebar Navigation
    sidebar_links = [
        ("Home", "main.php"),
        ("Customer Parcel Management", "customer_parcel.php"),
        ("Government Stock Management", "govStock.php"),
        ("Parcel Tracking", "tracking.php"),
        ("Fuel Stock", "fuel.php"),
        ("Notifications", "notifications.php"),
        ("Reports", "reports.php"),
    ]

    for link_text, link_href in sidebar_links:
        element = driver.find_element(By.LINK_TEXT, link_text)
        assert element.get_attribute("href").endswith(link_href)
        print(f"Navigation link '{link_text}' is present and correct.")

    # Test Image Slider
    image_slider = driver.find_elements(By.CLASS_NAME, "custom-slide")
    assert len(image_slider) >= 3
    print("Image slider contains images.")

    # Test CTA buttons
    track_button = driver.find_element(By.CLASS_NAME, "track-button")
    timetable_button = driver.find_element(By.CLASS_NAME, "timetable-button")
    book_button = driver.find_element(By.CLASS_NAME, "book-button")
    assert track_button.is_displayed() and timetable_button.is_displayed() and book_button.is_displayed()
    print("CTA buttons are visible.")

    # Scroll to timetable section
    driver.execute_script("arguments[0].scrollIntoView();", driver.find_element(By.ID, "timetable"))
    time.sleep(1)
    timetable = driver.find_element(By.TAG_NAME, "table")
    assert "Train Name" in timetable.text
    print("Timetable is displayed correctly.")

    # Test Logout Button
    logout_button = driver.find_element(By.CLASS_NAME, "logout")
    assert logout_button.is_displayed()
    logout_button.click()
    time.sleep(1)
    assert "login" in driver.current_url
    print("Logout successful.")

except Exception as e:
    print("Test failed:", e)

finally:
    driver.quit()
