-- Kuuzu Cart
--
-- @copyright Copyright (c) 2014 osCommerce; http://www.oscommerce.com
-- @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
--
-- @copyright Copyright (c) 2018 Kuuzu; https://kuuzu.org
-- @license MIT License; https://kuuzu.org/mitlicense.txt

ALTER TABLE kuu_address_book add CONSTRAINT kuu_address_book_customers_id_fkey FOREIGN KEY (customers_id) REFERENCES kuu_customers (customers_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_address_book add CONSTRAINT kuu_address_book_entry_country_id_fkey FOREIGN KEY (entry_country_id) REFERENCES kuu_countries (countries_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_address_book add CONSTRAINT kuu_address_book_entry_zone_id_fkey FOREIGN KEY (entry_zone_id) REFERENCES kuu_zones (zone_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE kuu_administrator_shortcuts add CONSTRAINT kuu_administrator_shortcuts_administrators_id_fkey FOREIGN KEY (administrators_id) REFERENCES kuu_administrators (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_administrators_access add CONSTRAINT kuu_administrators_access_administrators_id_fkey FOREIGN KEY (administrators_id) REFERENCES kuu_administrators (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_audit_log_rows add CONSTRAINT kuu_audit_log_audit_log_id_fkey FOREIGN KEY (audit_log_id) REFERENCES kuu_audit_log (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_banners_history add CONSTRAINT kuu_banners_history_banners_id_fkey FOREIGN KEY (banners_id) REFERENCES kuu_banners (banners_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_categories add CONSTRAINT kuu_categories_parent_id_fkey FOREIGN KEY (parent_id) REFERENCES kuu_categories (categories_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_categories_description add CONSTRAINT kuu_categories_description_categories_id_fkey FOREIGN KEY (categories_id) REFERENCES kuu_categories (categories_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_categories_description add CONSTRAINT kuu_categories_description_language_id_fkey FOREIGN KEY (language_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_configuration add CONSTRAINT kuu_configuration_configuration_group_id_fkey FOREIGN KEY (configuration_group_id) REFERENCES kuu_configuration_group (configuration_group_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_customers add CONSTRAINT kuu_customers_customers_default_address_id_fkey FOREIGN KEY (customers_default_address_id) REFERENCES kuu_address_book (address_book_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE kuu_languages add CONSTRAINT kuu_languages_currencies_id_fkey FOREIGN KEY (currencies_id) REFERENCES kuu_currencies (currencies_id) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE kuu_languages_definitions add CONSTRAINT kuu_languages_definitions_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_manufacturers_info add CONSTRAINT kuu_manufacturers_info_manufacturers_id_fkey FOREIGN KEY (manufacturers_id) REFERENCES kuu_manufacturers (manufacturers_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_manufacturers_info add CONSTRAINT kuu_manufacturers_info_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_newsletters_log add CONSTRAINT kuu_newsletters_log_newsletters_id_fkey FOREIGN KEY (newsletters_id) REFERENCES kuu_newsletters (newsletters_id) ON DELETE CASCADE ON UPDATE CASCADE;

--ALTER TABLE kuu_orders add CONSTRAINT kuu_orders_orders_status_fkey FOREIGN KEY (orders_status) REFERENCES kuu_orders_status (orders_status_id) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE kuu_orders_products add CONSTRAINT kuu_orders_products_orders_id_fkey FOREIGN KEY (orders_id) REFERENCES kuu_orders (orders_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_orders_products_download add CONSTRAINT kuu_orders_products_download_orders_id_fkey FOREIGN KEY (orders_id) REFERENCES kuu_orders (orders_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_orders_products_variants add CONSTRAINT kuu_orders_products_variants_orders_id_fkey FOREIGN KEY (orders_id) REFERENCES kuu_orders (orders_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_orders_status add CONSTRAINT kuu_orders_status_language_id_fkey FOREIGN KEY (language_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_orders_status_history add CONSTRAINT kuu_orders_status_history_orders_id_fkey FOREIGN KEY (orders_id) REFERENCES kuu_orders (orders_id) ON DELETE CASCADE ON UPDATE CASCADE;
--ALTER TABLE kuu_orders_status_history add CONSTRAINT kuu_orders_status_history_orders_status_id_fkey FOREIGN KEY (orders_status_id) REFERENCES kuu_orders_status (orders_status_id) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE kuu_orders_total add CONSTRAINT kuu_orders_total_orders_id_fkey FOREIGN KEY (orders_id) REFERENCES kuu_orders (orders_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_orders_transactions_history add CONSTRAINT kuu_orders_transactions_history_orders_id_fkey FOREIGN KEY (orders_id) REFERENCES kuu_orders (orders_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_orders_transactions_status add CONSTRAINT kuu_orders_transactions_status_language_id_fkey FOREIGN KEY (language_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_product_attributes add CONSTRAINT kuu_product_attributes_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_product_attributes add CONSTRAINT kuu_product_attributes_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_product_types_assignments add CONSTRAINT kuu_product_types_assignments_types_id_fkey FOREIGN KEY (types_id) REFERENCES kuu_product_types (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products add CONSTRAINT kuu_products_parent_id_fkey FOREIGN KEY (parent_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
--ALTER TABLE kuu_products add CONSTRAINT kuu_products_products_weight_class_fkey FOREIGN KEY (products_weight_class) REFERENCES kuu_weight_classes (weight_class_id) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE kuu_products add CONSTRAINT kuu_products_products_tax_class_id_fkey FOREIGN KEY (products_tax_class_id) REFERENCES kuu_tax_class (tax_class_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE kuu_products add CONSTRAINT kuu_products_products_types_id_fkey FOREIGN KEY (products_types_id) REFERENCES kuu_product_types (id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE kuu_products add CONSTRAINT kuu_products_manufacturers_id_fkey FOREIGN KEY (manufacturers_id) REFERENCES kuu_manufacturers (manufacturers_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE kuu_products_description add CONSTRAINT kuu_products_description_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_products_description add CONSTRAINT kuu_products_description_language_id_fkey FOREIGN KEY (language_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_images add CONSTRAINT kuu_products_images_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_images_groups add CONSTRAINT kuu_products_images_groups_language_id_fkey FOREIGN KEY (language_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_notifications add CONSTRAINT kuu_products_notifications_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_products_notifications add CONSTRAINT kuu_products_notifications_customers_id_fkey FOREIGN KEY (customers_id) REFERENCES kuu_customers (customers_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_to_categories add CONSTRAINT kuu_products_to_categories_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_products_to_categories add CONSTRAINT kuu_products_to_categories_categories_id_fkey FOREIGN KEY (categories_id) REFERENCES kuu_categories (categories_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_variants add CONSTRAINT kuu_products_variants_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
--ALTER TABLE kuu_products_variants add CONSTRAINT kuu_products_variants_products_variants_values_id_fkey FOREIGN KEY (products_variants_values_id) REFERENCES kuu_products_variants_values (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_variants_groups add CONSTRAINT kuu_products_variants_groups_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_products_variants_values add CONSTRAINT kuu_products_variants_values_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;
--ALTER TABLE kuu_products_variants_values add CONSTRAINT kuu_products_variants_values_products_variants_groups_id_fkey FOREIGN KEY (products_variants_groups_id) REFERENCES kuu_products_variants_groups (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_reviews add CONSTRAINT kuu_reviews_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_reviews add CONSTRAINT kuu_reviews_customers_id_fkey FOREIGN KEY (customers_id) REFERENCES kuu_customers (customers_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_reviews add CONSTRAINT kuu_reviews_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_shipping_availability add CONSTRAINT kuu_shipping_availability_languages_id_fkey FOREIGN KEY (languages_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_shopping_carts add CONSTRAINT kuu_shopping_carts_customers_id_fkey FOREIGN KEY (customers_id) REFERENCES kuu_customers (customers_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_shopping_carts add CONSTRAINT kuu_shopping_carts_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_shopping_carts_custom_variants_values add CONSTRAINT kuu_shopping_carts_custom_variants_values_customers_id_fkey FOREIGN KEY (customers_id) REFERENCES kuu_customers (customers_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_shopping_carts_custom_variants_values add CONSTRAINT kuu_shopping_carts_custom_variants_values_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;
--ALTER TABLE kuu_shopping_carts_custom_variants_values add CONSTRAINT kuu_shopping_carts_custom_variants_values_products_variants_values_id_fkey FOREIGN KEY (products_variants_values_id) REFERENCES kuu_products_variants_values (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_specials add CONSTRAINT kuu_specials_products_id_fkey FOREIGN KEY (products_id) REFERENCES kuu_products (products_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_tax_rates add CONSTRAINT kuu_tax_rates_tax_zone_id_fkey FOREIGN KEY (tax_zone_id) REFERENCES kuu_geo_zones (geo_zone_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_tax_rates add CONSTRAINT kuu_tax_rates_tax_class_id_fkey FOREIGN KEY (tax_class_id) REFERENCES kuu_tax_class (tax_class_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_templates_boxes_to_pages add CONSTRAINT kuu_templates_boxes_to_pages_templates_boxes_id_fkey FOREIGN KEY (templates_boxes_id) REFERENCES kuu_templates_boxes (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_templates_boxes_to_pages add CONSTRAINT kuu_templates_boxes_to_pages_templates_id_fkey FOREIGN KEY (templates_id) REFERENCES kuu_templates (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_weight_classes add CONSTRAINT kuu_weight_classes_language_id_fkey FOREIGN KEY (language_id) REFERENCES kuu_languages (languages_id) ON DELETE CASCADE ON UPDATE CASCADE;

--ALTER TABLE kuu_weight_classes_rules add CONSTRAINT kuu_weight_classes_weight_class_from_id_fkey FOREIGN KEY (weight_class_from_id) REFERENCES kuu_weight_classes (weight_class_id) ON DELETE CASCADE ON UPDATE CASCADE;
--ALTER TABLE kuu_weight_classes_rules add CONSTRAINT kuu_weight_classes_weight_class_to_id_fkey FOREIGN KEY (weight_class_to_id) REFERENCES kuu_weight_classes (weight_class_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_whos_online add CONSTRAINT kuu_whos_online_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES kuu_customers (customers_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_zones add CONSTRAINT kuu_zones_zone_country_id_fkey FOREIGN KEY (zone_country_id) REFERENCES kuu_countries (countries_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE kuu_zones_to_geo_zones add CONSTRAINT kuu_zones_to_geo_zones_zone_country_id_fkey FOREIGN KEY (zone_country_id) REFERENCES kuu_countries (countries_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_zones_to_geo_zones add CONSTRAINT kuu_zones_to_geo_zones_zone_id_fkey FOREIGN KEY (zone_id) REFERENCES kuu_zones (zone_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE kuu_zones_to_geo_zones add CONSTRAINT kuu_zones_to_geo_zones_geo_zone_id_fkey FOREIGN KEY (geo_zone_id) REFERENCES kuu_geo_zones (geo_zone_id) ON DELETE CASCADE ON UPDATE CASCADE;
