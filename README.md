
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
*Because the Elegoo UNO outputs 5V from its TX port, and the ESP32 can only recieve 3.3V, a voltage divider was needed when connecting the Elegoo UNO TX port to the ESP32 RX port. Refer to the schematics for more detailed wiring instructions.

To facilitate communication between the ESP32 Module and the Elegoo UNO the following actions were taken:
1. The RX pin on the Elegoo UNO (pin 1) was connected to the TX2 pin on the ESP32 (pin 17)
2. A ground pin on the Elegoo UNO was connected to a ground pin on the ESP32.
3. A voltage divider was created:

   a. To calculate the resistors needed for the correct voltage output, a [Voltage Divider Calculator](https://ohmslawcalculator.com/voltage-divider-calculator) was used. 5V was input as the source voltage (Vs) and 3.3V was input as the output voltage (Vout). A 220 ohm resistor was modeled as resistor one, and the calculated value for resistor two was found to be about 427 ohms.
   
   b. To create the divider, the Elegoo TX pin was connected to the two resistors in series (R1 then R2), and then connected to ground.
   
   c. A jumper wire was inserted in parallel at the junction of the two resistors and connected to the RX2 port (pin 16) on the ESP32.

4. To test communication between the Elegoo UNO and the ESP32, the following code originally from [this page](https://www.programmingboss.com/2021/04/esp32-arduino-serial-communication-with-code.html#gsc.tab=0) was used:

```c
///Elegoo Uno Code
void setup() {
  Serial.begin(9600);
}
void loop() {
  Serial.println("Hello Boss");
  delay(1500);
}


///ESP32 Code
#define RXp2 16
#define TXp2 17
void setup() {
   //put your setup code here, to run once:
  Serial.begin(115200);
  Serial2.begin(9600, SERIAL_8N1, RXp2, TXp2);
}
void loop() {
    Serial.println("Message Received: ");
    Serial.println(Serial2.readString());
}
```

5. To use the example code, two Arduino IDE windows were opened, and the Elegoo UNO code was copied into one window, and the ESP32 code was copied into the other.
  
6. The corresponding device and port were selected for each window.

7. The codes were uploaded to the devices. (To upload to the Elegoo Uno, the TX and RX ports cannot be connected, so when uploading to the Elegoo Uno, they were temporarily disconnected while uploading, then reconnected.

8. After confirming communication between the devices, the following code was created to communicate data from the moisture sensors.
   
# Data Management
## Data Model
[Db Diagram](https://dbdiagram.io/d/64aacd0402bd1c4a5ec048b0)
## Database Management System

## API

# Web Dashboard
