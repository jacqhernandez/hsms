/* Clients */
INSERT INTO `clients` (`id`, `name`, `telephone_number`, `address`, `email`, `tin`, `contact_person`, `credit_limit`, `status`, `payment_terms`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Ace Hardware', '1234567', 'Quezon City', 'acehardware@gmail.com', '123456780', 'Mr. Ace', '1000', 'Good', 'Cash', '2', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);
INSERT INTO `clients` (`id`, `name`, `telephone_number`, `address`, `email`, `tin`, `contact_person`, `credit_limit`, `status`, `payment_terms`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Boysen', '4558721', 'San Juan', 'boysen@yahoo.com', '423123642', 'Mr. Boyce', '500', 'Good', '15 Days', '2', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);
INSERT INTO `clients` (`id`, `name`, `telephone_number`, `address`, `email`, `tin`, `contact_person`, `credit_limit`, `status`, `payment_terms`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Caltex', '1158399', 'Colorado', 'caltexcompany@gmail.com', '123456777', 'Mr. Cal', '6000', 'Good', '30 Days', '2', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);

/* Users */
INSERT INTO `users` (`id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'admin', 'adminadmin', 'General Manager', NULL, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');
INSERT INTO `users` (`id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'sales', 'salessales', 'Sales', NULL, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');
INSERT INTO `users` (`id`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'accounting', 'accounting', 'Accounting', NULL, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

/* Items */
INSERT INTO `items` (`id`, `name`, `unit`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Nails', 'Pcs', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);
INSERT INTO `items` (`id`, `name`, `unit`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Paint', 'Liters', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);
INSERT INTO `items` (`id`, `name`, `unit`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Wood', 'Pcs', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);

/* Suppliers */
INSERT INTO `suppliers` (`id`, `name`, `telephone_number`, `tin`, `address`, `email`, `payment_terms`, `contact_person`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Nickel Corporation', '8123532', '12346789', 'Juba', 'nikl@gmail.com', 'Cash', 'Mr. Nick', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);
INSERT INTO `suppliers` (`id`, `name`, `telephone_number`, `tin`, `address`, `email`, `payment_terms`, `contact_person`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Pryce Corporation', '1234565', '123123123', 'Paranaque', 'ppc@gmail.com', '30 Days', 'Mr. Pryce', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);
INSERT INTO `suppliers` (`id`, `name`, `telephone_number`, `tin`, `address`, `email`, `payment_terms`, `contact_person`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Philex Mining', '9542314', '912341231', 'Pasig', 'px@yahoo.com', '30 Days', 'Mr. Phil', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);

/* Reason */
INSERT INTO `reasons` (`id`, `reason`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Delaying Tactics', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL);