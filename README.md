
This project was created for the ASABE AIM digital agriculture hackathon 2023 by Cheyenne Simmons, Juliet Norton, Autumn Denny, Maggie Barnes, and Tiffany Coogle.

# Overview
The goal of this project is to produce a soil moisture logging system with both a hardware and software component. The hardware was created using an R3 Uno Elegoo, an ESP32, and a few Songhe capacitive soil moisture sensors. The web dashboard was developed with PHP, CSS, and HTML and is supported on the backend by MySQL and FastAPI.

# Hardware
## Supplies Used
- [Songhe soil sensors](https://www.amazon.com/dp/B07SYBSHGX?psc=1&ref=ppx_yo2ov_dt_b_product_details)
- [Elegoo UNO Project Super Starter Kit](https://www.amazon.com/dp/B01D8KOZF4?psc=1&ref=ppx_yo2ov_dt_b_product_details)
- [ESP32](https://www.amazon.com/ESP-WROOM-32-Development-Dual-Mode-Microcontroller-Integrated/dp/B07WCG1PLV)

## Wiring Diagram

## Communication Between the Elegoo and ESP32 Module
To facilitate communication between the Elegoo UNO and the ESP32, serial communication between the two was established using the RX, TX, and ground ports using the following steps:

1. The Elegoo UNO's RX port (pin 1) was connected to the TX2 port (pin 17) on the ESP32.
2. A ground port on the Elegoo UNO was connected to a grount port on the ESP32.
3. The Elegoos UNO's TX port (pin 2) was connected to the RX2 port (pin 16) on the ESP 32.

NOTE: The UNO outputs 5V, however the ESP32 can only recive 3.3V. Because of this, a voltage divider was created using the breadboard attached to the UNO, a 220 ohm resistor, an 100 ohm resistor, and a 330 ohm resistor to reduce the voltage from 5V to 3.3V.Refer to the wiring diagram for more information on setting up the circuit.

6. To test the communication between the two devices, source code from [Programmingboss.com](https://www.programmingboss.com/2021/04/esp32-arduino-serial-communication-with-code.html#gsc.tab=0) was used.
```c
// this sample code provided by www.programmingboss.com
void setup() {
  Serial.begin(9600);
}
void loop() {
  Serial.println("Hello Boss");
  delay(1500);
}
```
```c
// this sample code provided by www.programmingboss.com
#define RXp2 16
#define TXp2 17
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  Serial2.begin(9600, SERIAL_8N1, RXp2, TXp2);
}
void loop() {
    Serial.println("Message Received: ");
    Serial.println(Serial2.readString());
}
```
6. After confirming communcation between the devices, the following code was uploaded to the Elegoo UNO.
```c
//Pins the moisture sensors connect to
int sensorZero = A0;
int sensorOne = A1;
int sensorTwo = A2;

//Variables for the outputs of the sensors
float outputZero ;
float outputOne ;
float outputTwo ;

//Pin to turn off and on the sensors
int VoltagePin = 8;


void setup() {

//Begin serial communications at 9600 Baud rate and let user know the sensor is reading the moisture
  Serial.begin(9600);
  Serial.println("Reading From the Sensor ...");
  delay(2000);

//Set pin to output
  pinMode(VoltagePin, OUTPUT);
}

void loop() {

//Turn on sensors
  digitalWrite(VoltagePin, HIGH);

//Allow a delay to let the sensors completely turn on 
  delay (500);

//Read the output values of the sensors
  outputZero= analogRead(sensorZero);
  outputOne= analogRead(sensorOne);
  outputTwo= analogRead(sensorTwo);
  
  delay(200);

//SENSOR 1
//Dry: 560, Wet: 288, 
//PercentageOneDry is the percent amount that the sensor is dry
  int PercentageOneDry = ((outputZero - 288)/270)*100;
//Subtract dry percentage from 100 to get the wet percentage
  int PercentageOneWet = 100 - PercentageOneDry;

//Print results
  Serial.print("Sensor One Moisture: ");
  Serial.print(PercentageOneWet);
  Serial.print("%");
  Serial.print('\n');

  delay(1000);

//Dry: 563, Wet: 289, Difference 274
//PercentageOneDry is the percent amount that the sensor is dry
  int PercentageTwoDry = ((outputOne - 289)/274)*100;
//Subtract dry percentage from 100 to get the wet percentage
  int PercentageTwoWet = 100 - PercentageTwoDry;

//Print results
  Serial.print("Sensor Two Moisture: ");
  Serial.print(PercentageTwoWet);
  Serial.print("%");
  Serial.print('\n');

  delay(1000);

//Dry:559, Wet: 286, Difference 273
//PercentageOneDry is the percent amount that the sensor is dry
int PercentageThreeDry = ((outputTwo - 286)/273)*100;
//Subtract dry percentage from 100 to get the wet percentage
int PercentageThreeWet = 100 - PercentageThreeDry;

//Print results
  Serial.print("Sensor Three Moisture: ");
  Serial.print(PercentageThreeWet);
  Serial.print("%");
  Serial.print('\n');

  delay(1000);

//Turn off sensors
  digitalWrite(VoltagePin, LOW);
  
//Wait 5 minutes
  delay(3000);

}
```
7. The ESP32 code was kept the same, except for an addition of a delay to match the delay in the Elegoo UNO code.
```c
void loop() {
    
    Serial.println(Serial2.readString());
    delay(3000); // added code
}
```
# Data Management
## Data Model
[Db Diagram](https://dbdiagram.io/d/64aacd0402bd1c4a5ec048b0)
## Database Management System

## API

# Web Dashboard
