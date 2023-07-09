//For programming the Arduino itself. Does not require the ESP32 to be connected and ready.
// Try sticking the sensor in water for a "wet" reading and leave it in air for a "dry" reading

int sensor_pin = A0;
int output_value ;

void setup() {
  Serial.begin(9600);
  Serial.println("Reading From the Sensor ...");
  delay(2000);
}

void loop() {
  output_value = analogRead(sensor_pin);
  delay(200);

  Serial.print("Moisture : ");
  Serial.print(output_value);
  Serial.println("%");
  delay(1000);
}
