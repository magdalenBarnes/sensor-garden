CREATE TABLE `Soil_Moisture_Measurements` (
  `id` int PRIMARY KEY,
  `sensor_id` int,
  `moisture_value` int,
  `measurement_date_time` datetime
);

CREATE TABLE `Sensors` (
  `id` int PRIMARY KEY,
  `manufacturer` varchar(255),
  `date_manufactured` datetime,
  `date_installed` datetime,
  `date_retired` datetime,
  `field_id` int,
  `location` wkt_point COMMENT 'https://en.wikipedia.org/wiki/Well-known_text_representation_of_geometry'
);

CREATE TABLE `Field` (
  `id` int PRIMARY KEY,
  `name` varchar(255),
  `mode` ENUM ('indoor', 'outdoor'),
  `polygon` wkt_geometery COMMENT 'https://en.wikipedia.org/wiki/Well-known_text_representation_of_geometry',
  `user_id` int
);

CREATE TABLE `Plant` (
  `id` int PRIMARY KEY,
  `field_id` int,
  `species_itis_id` id,
  `variety` varchar(255)
);

CREATE TABLE `User` (
  `id` int PRIMARY KEY,
  `email` email,
  `password` varchar(255)
);

CREATE TABLE `Notifications` (
  `id` int PRIMARY KEY,
  `event` ENUM ('dry'),
  `sensor_id` int,
  `notifcation_date_time` datetime,
  `soil_moisture_measurement_ids` int_array COMMENT 'a notification is triggered by an assessment of many measurements',
  `active` boolean COMMENT 'Flag that specifies if the notificaiton is active. Will be turned to false once irrigated.'
);

CREATE TABLE `Irrigation_Event` (
  `id` int PRIMARY KEY,
  `irrigation_event_date_time` datetime,
  `sensor_id` int
);

ALTER TABLE `Soil_Moisture_Measurements` ADD FOREIGN KEY (`sensor_id`) REFERENCES `Sensors` (`id`);

ALTER TABLE `Sensors` ADD FOREIGN KEY (`field_id`) REFERENCES `Field` (`id`);

ALTER TABLE `Field` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `Plant` ADD FOREIGN KEY (`field_id`) REFERENCES `Field` (`id`);

ALTER TABLE `Notifications` ADD FOREIGN KEY (`sensor_id`) REFERENCES `Sensors` (`id`);

ALTER TABLE `Soil_Moisture_Measurements` ADD FOREIGN KEY (`id`) REFERENCES `Notifications` (`soil_moisture_measurement_ids`);

ALTER TABLE `Irrigation_Event` ADD FOREIGN KEY (`sensor_id`) REFERENCES `Sensors` (`id`);
