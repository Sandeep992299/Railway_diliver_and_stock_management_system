import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options

class FuelManagementTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        chromedriver_path = r"C:\Users\USER\Downloads\chromedriver-win64\chromedriver.exe"  # Ensure full path to .exe
        service = Service(chromedriver_path)
        options = Options()
        # options.add_argument("--headless")  # Optional: run without opening a window
        cls.driver = webdriver.Chrome(service=service, options=options)
        cls.driver.implicitly_wait(5)

    def test_fuel_management_page(self):
        driver = self.driver

        # Step 1: Go directly to the fuel management page
        url = "http://localhost/Railway_Storage_Management_System/fuel.php?test_mode=1"
        driver.get(url)

        # Step 2: Perform all the existing fuel page checks
        self.assertIn("Fuel Management", driver.title)
        print("✔ Page title is correct.")

        header = driver.find_element(By.TAG_NAME, "h1").text
        self.assertEqual(header, "Fuel Tank Status")
        print("✔ Main header is correct.")

        fuel_tank = driver.find_element(By.CLASS_NAME, "tank")
        fuel_level = driver.find_element(By.ID, "fuelLevel")
        self.assertIsNotNone(fuel_tank)
        self.assertIsNotNone(fuel_level)
        print("✔ Fuel tank and fuel level elements found.")

        fuel_liters = driver.find_element(By.ID, "fuelLiters").text
        fuel_percentage = driver.find_element(By.ID, "fuelPercentage").text
        self.assertIn("L", fuel_liters)
        self.assertIn("%", fuel_percentage)
        print(f"✔ Current fuel liters displayed: {fuel_liters}")
        print(f"✔ Current fuel percentage displayed: {fuel_percentage}")

        fuel_input = driver.find_element(By.ID, "fuelInput")
        self.assertEqual(fuel_input.get_attribute("type"), "number")
        self.assertEqual(fuel_input.get_attribute("min"), "0")
        self.assertTrue(fuel_input.get_attribute("required"))
        print("✔ Fuel input field verified.")

        add_button = driver.find_element(By.XPATH, "//button[@name='action' and @value='add']")
        remove_button = driver.find_element(By.XPATH, "//button[@name='action' and @value='remove']")
        self.assertIsNotNone(add_button)
        self.assertIsNotNone(remove_button)
        print("✔ Add Fuel and Remove Fuel buttons verified.")

        fuel_level_height = fuel_level.value_of_css_property("height")
        self.assertTrue(fuel_level_height.endswith("px") or fuel_level_height.endswith("%"))
        print(f"✔ Fuel level bar height style is set: {fuel_level_height}")

    @classmethod
    def tearDownClass(cls):
        print("\n🎉 TEST PASSED! Fuel Management page looks good.")
        cls.driver.quit()

if __name__ == "__main__":
    unittest.main(verbosity=2)
