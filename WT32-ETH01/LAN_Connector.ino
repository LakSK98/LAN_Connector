#include <DHT.h>
#include <ETH.h>
#include <HTTPClient.h>

#define DHTPIN 14 // Pin where the DHT11 sensor is connected
#define DHTTYPE DHT11 // Type of DHT sensor
#define ledPin 12

DHT dht(DHTPIN, DHTTYPE);

// Select the IP address according to your local network
// Uncomment below line if you use static IP
// IPAddress myIP(192, 168, 8, 195);
// IPAddress myGW(192, 168, 8, 1);
// IPAddress mySN(255, 255, 255, 0);

// Replace IP address with server's IP
const char *phpScriptURL = "http://192.168.8.142/lan/save_data.php";

void setup() {
  Serial.begin(115200);
  ETH.begin(ETH_PHY_ADDR, ETH_PHY_POWER);
  // Static IP, leave without this line to get IP via DHCP
  // ETH.config(myIP, myGW, mySN);
  // Wait for the IP address to be obtained
  delay(10000);
  Serial.print("Obtained IP address: ");
  Serial.println(ETH.localIP());
  // Set the LED pin as output
  pinMode(ledPin, OUTPUT);
  // Set the input pin as input
  pinMode(DHTPIN, INPUT);
  dht.begin();
}

void loop() {
  // Read the temperature and humidity
  float humidity = dht.readHumidity();
  float temperature = dht.readTemperature();

  // Print the temperature and humidity to the serial monitor
  Serial.print("Humidity: ");
  Serial.print(humidity);
  Serial.print("%\t");
  Serial.print("Temperature: ");
  Serial.print(temperature);
  Serial.print("°C\n");

  // Turn on the LED
  digitalWrite(ledPin, HIGH);
  // Wait 1 second as LED on
  delay(1000);
  // Turn off the LED
  digitalWrite(ledPin, LOW);
  sendSensorData(humidity, temperature);
  delay(5000);
}

void sendSensorData(float humidity, float temperature) {
    HTTPClient http;
    String url = String(phpScriptURL) + "?humidity=" + String(humidity) + "&temperature=" + String(temperature);
    http.begin(url);
    int httpCode = http.GET();
    if (httpCode > 0) {
        Serial.println("Data sent successfully");
    } else {
        Serial.println("Error sending data");
    }
    http.end();
}