from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
import time
import unittest


class ParcelTrackingTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        # Correct way to set the driver path using Service
        chrome_driver_path = r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe"
        service = Service(chrome_driver_path)
        cls.driver = webdriver.Chrome(service=service)

        cls.driver.get("http://localhost/Railway_Storage_Management_System/tracking.php")
        cls.driver.maximize_window()
        time.sleep(1)

    def test_empty_input(self):
        driver = self.driver
        input_field = driver.find_element(By.ID, "parcelId")
        search_button = driver.find_element(By.ID, "searchButton")

        input_field.clear()
        search_button.click()
        time.sleep(1)

        status_label = driver.find_element(By.ID, "statusLabel")
        self.assertEqual(status_label.text, "Please enter a valid Parcel ID.")
        self.assertIn("not-found", status_label.get_attribute("class"))

    def test_parcel_123(self):
        driver = self.driver
        input_field = driver.find_element(By.ID, "parcelId")
        search_button = driver.find_element(By.ID, "searchButton")

        input_field.clear()
        input_field.send_keys("123")
        search_button.click()
        time.sleep(1)

        status_label = driver.find_element(By.ID, "statusLabel")
        self.assertEqual(status_label.text, "Status for Parcel ID 123: In Transit")
        self.assertIn("in-transit", status_label.get_attribute("class"))

    def test_parcel_456(self):
        driver = self.driver
        input_field = driver.find_element(By.ID, "parcelId")
        search_button = driver.find_element(By.ID, "searchButton")

        input_field.clear()
        input_field.send_keys("456")
        search_button.click()
        time.sleep(1)

        status_label = driver.find_element(By.ID, "statusLabel")
        self.assertEqual(status_label.text, "Status for Parcel ID 456: Delivered")
        self.assertIn("delivered", status_label.get_attribute("class"))

    def test_parcel_789(self):
        driver = self.driver
        input_field = driver.find_element(By.ID, "parcelId")
        search_button = driver.find_element(By.ID, "searchButton")

        input_field.clear()
        input_field.send_keys("789")
        search_button.click()
        time.sleep(1)

        status_label = driver.find_element(By.ID, "statusLabel")
        self.assertEqual(status_label.text, "Status for Parcel ID 789: At Station")
        self.assertIn("at-station", status_label.get_attribute("class"))

    def test_unknown_parcel(self):
        driver = self.driver
        input_field = driver.find_element(By.ID, "parcelId")
        search_button = driver.find_element(By.ID, "searchButton")

        input_field.clear()
        input_field.send_keys("999")
        search_button.click()
        time.sleep(1)

        status_label = driver.find_element(By.ID, "statusLabel")
        self.assertEqual(status_label.text, "Status for Parcel ID 999: Not Found")
        self.assertIn("not-found", status_label.get_attribute("class"))

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()


if __name__ == "__main__":
    unittest.main()
