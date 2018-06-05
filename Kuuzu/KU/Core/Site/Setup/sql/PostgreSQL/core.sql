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

DROP TABLE IF EXISTS kuu_address_book CASCADE;
CREATE TABLE kuu_address_book (
  address_book_id serial NOT NULL,
  customers_id integer NOT NULL,
  entry_gender char(1),
  entry_company varchar(255),
  entry_firstname varchar(255) NOT NULL,
  entry_lastname varchar(255) NOT NULL,
  entry_street_address varchar(255) NOT NULL,
  entry_suburb varchar(255),
  entry_postcode varchar(255),
  entry_city varchar(255) NOT NULL,
  entry_state varchar(255),
  entry_country_id integer NOT NULL,
  entry_zone_id integer,
  entry_telephone varchar(255),
  entry_fax varchar(255),
  PRIMARY KEY (address_book_id)
);

CREATE INDEX kuu_address_book_customers_id_idx ON kuu_address_book USING btree (customers_id);
CREATE INDEX kuu_address_book_entry_country_id_idx ON kuu_address_book USING btree (entry_country_id);
CREATE INDEX kuu_address_book_entry_zone_id_idx ON kuu_address_book USING btree (entry_zone_id);

DROP TABLE IF EXISTS kuu_administrator_shortcuts CASCADE;
CREATE TABLE kuu_administrator_shortcuts (
  administrators_id integer NOT NULL,
  module varchar(255) NOT NULL,
  last_viewed timestamp(0),
  PRIMARY KEY (administrators_id, module)
);

CREATE INDEX kuu_administrator_shortcuts_administrators_id_idx ON kuu_administrator_shortcuts USING btree (administrators_id);

DROP TABLE IF EXISTS kuu_administrators CASCADE;
CREATE TABLE kuu_administrators (
  id serial NOT NULL,
  user_name varchar(255) NOT NULL,
  user_password varchar(40) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_administrators_user_name_idx ON kuu_administrators USING btree (user_name);

DROP TABLE IF EXISTS kuu_administrators_access CASCADE;
CREATE TABLE kuu_administrators_access (
  administrators_id integer NOT NULL,
  module varchar(255) NOT NULL,
  PRIMARY KEY (administrators_id, module)
);

CREATE INDEX kuu_administrators_access_administrators_id_idx ON kuu_administrators_access USING btree (administrators_id);

DROP TABLE IF EXISTS kuu_audit_log CASCADE;
CREATE TABLE kuu_audit_log (
  id serial NOT NULL,
  site varchar(32) NOT NULL,
  application varchar(32) NOT NULL,
  action varchar(160) NOT NULL,
  row_id integer NOT NULL,
  user_id integer NOT NULL,
  ip_address integer NOT NULL,
  action_type varchar(255) NOT NULL,
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_audit_log_row_id_idx ON kuu_audit_log USING btree (row_id);
CREATE INDEX kuu_audit_log_user_id_idx ON kuu_audit_log USING btree (user_id);
CREATE INDEX kuu_audit_log_req_idx ON kuu_audit_log USING btree (site, application, action);

DROP TABLE IF EXISTS kuu_audit_log_rows CASCADE;
CREATE TABLE kuu_audit_log_rows (
  id serial NOT NULL,
  audit_log_id integer NOT NULL,
  row_key varchar(255) NOT NULL,
  old_value text NOT NULL,
  new_value text NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_audit_log_rows_audit_log_id_idx ON kuu_audit_log_rows USING btree (audit_log_id);

DROP TABLE IF EXISTS kuu_banners CASCADE;
CREATE TABLE kuu_banners (
  banners_id serial NOT NULL,
  banners_title varchar(255) NOT NULL,
  banners_url varchar(255) NOT NULL,
  banners_image varchar(255) NOT NULL,
  banners_group varchar(255) NOT NULL,
  banners_html_text text,
  expires_impressions integer DEFAULT 0,
  expires_date timestamp(0) DEFAULT NULL,
  date_scheduled timestamp(0) DEFAULT NULL,
  date_added timestamp(0) NOT NULL,
  date_status_change timestamp(0) DEFAULT NULL,
  status integer NOT NULL DEFAULT 1,
  PRIMARY KEY (banners_id)
);

CREATE INDEX kuu_banners_banners_group_idx ON kuu_banners USING btree (banners_group);
CREATE INDEX kuu_banners_expires_date_idx ON kuu_banners USING btree (expires_date);

DROP TABLE IF EXISTS kuu_banners_history CASCADE;
CREATE TABLE kuu_banners_history (
  banners_history_id serial NOT NULL,
  banners_id integer NOT NULL,
  banners_shown integer NOT NULL DEFAULT 0,
  banners_clicked integer NOT NULL DEFAULT 0,
  banners_history_date timestamp(0) NOT NULL,
  PRIMARY KEY (banners_history_id)
);

CREATE INDEX kuu_banners_history_banners_id_idx ON kuu_banners_history USING btree (banners_id);

DROP TABLE IF EXISTS kuu_categories CASCADE;
CREATE TABLE kuu_categories (
  categories_id serial NOT NULL,
  categories_image varchar(255),
  parent_id integer,
  sort_order integer,
  date_added timestamp(0),
  last_modified timestamp(0),
  PRIMARY KEY (categories_id)
);

CREATE INDEX kuu_categories_parent_id_idx ON kuu_categories USING btree (parent_id);

DROP TABLE IF EXISTS kuu_categories_description CASCADE;
CREATE TABLE kuu_categories_description (
  categories_id integer NOT NULL,
  language_id integer NOT NULL,
  categories_name varchar(255) NOT NULL,
  PRIMARY KEY (categories_id, language_id)
);

CREATE INDEX kuu_categories_description_categories_id_idx ON kuu_categories_description USING btree (categories_id);
CREATE INDEX kuu_categories_description_language_id_idx ON kuu_categories_description USING btree (language_id);
CREATE INDEX kuu_categories_description_categories_name_idx ON kuu_categories_description USING btree (categories_name);

DROP TABLE IF EXISTS kuu_configuration CASCADE;
CREATE TABLE kuu_configuration (
  configuration_id serial NOT NULL,
  configuration_title varchar(255) NOT NULL,
  configuration_key varchar(255) NOT NULL,
  configuration_value text,
  configuration_description varchar(255) NOT NULL,
  configuration_group_id integer NOT NULL,
  sort_order integer,
  last_modified timestamp(0),
  date_added timestamp(0) NOT NULL,
  use_function varchar(255) NULL,
  set_function varchar(255) NULL,
  PRIMARY KEY (configuration_id)
);

CREATE INDEX kuu_configuration_configuration_group_id_idx ON kuu_configuration USING btree (configuration_group_id);

DROP TABLE IF EXISTS kuu_configuration_group CASCADE;
CREATE TABLE kuu_configuration_group (
  configuration_group_id serial NOT NULL,
  configuration_group_title varchar(255) NOT NULL,
  configuration_group_description varchar(255) NOT NULL,
  sort_order integer,
  visible integer DEFAULT 1,
  PRIMARY KEY (configuration_group_id)
);

DROP TABLE IF EXISTS kuu_counter CASCADE;
CREATE TABLE kuu_counter (
  startdate timestamp(0),
  counter integer
);

DROP TABLE IF EXISTS kuu_countries CASCADE;
CREATE TABLE kuu_countries (
  countries_id serial NOT NULL,
  countries_name varchar(255) NOT NULL,
  countries_iso_code_2 char(2) NOT NULL,
  countries_iso_code_3 char(3) NOT NULL,
  address_format varchar(255),
  PRIMARY KEY (countries_id)
);

CREATE INDEX kuu_countries_countries_name_idx ON kuu_countries USING btree (countries_name);
CREATE INDEX kuu_countries_countries_iso_code_2_idx ON kuu_countries USING btree (countries_iso_code_2);
CREATE INDEX kuu_countries_countries_iso_code_3_idx ON kuu_countries USING btree (countries_iso_code_3);

DROP TABLE IF EXISTS kuu_credit_cards CASCADE;
CREATE TABLE kuu_credit_cards (
  id serial NOT NULL,
  credit_card_name varchar(255) NOT NULL,
  pattern varchar(255) NOT NULL,
  credit_card_status char(1) NOT NULL,
  sort_order integer,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS kuu_currencies CASCADE;
CREATE TABLE kuu_currencies (
  currencies_id serial NOT NULL,
  title varchar(255) NOT NULL,
  code char(3) NOT NULL,
  symbol_left varchar(12),
  symbol_right varchar(12),
  decimal_places char(1),
  value numeric(13,8),
  last_updated timestamp(0),
  PRIMARY KEY (currencies_id)
);

CREATE INDEX kuu_currencies_code ON kuu_currencies USING btree (code);

DROP TABLE IF EXISTS kuu_customers CASCADE;
CREATE TABLE kuu_customers (
  customers_id serial NOT NULL,
  customers_gender char(1),
  customers_firstname varchar(255) NOT NULL,
  customers_lastname varchar(255) NOT NULL,
  customers_dob timestamp(0),
  customers_email_address varchar(255) NOT NULL,
  customers_default_address_id integer,
  customers_telephone varchar(255),
  customers_fax varchar(255),
  customers_password varchar(40),
  customers_newsletter char(1),
  customers_status integer DEFAULT 1,
  customers_ip_address varchar(15),
  date_last_logon timestamp(0),
  number_of_logons integer DEFAULT 0,
  date_account_created timestamp(0),
  date_account_last_modified timestamp(0),
  global_product_notifications integer DEFAULT 0,
  PRIMARY KEY (customers_id)
);

CREATE INDEX kuu_customers_customers_default_address_id_idx ON kuu_customers USING btree (customers_default_address_id);

DROP TABLE IF EXISTS kuu_fk_relationships CASCADE;
CREATE TABLE kuu_fk_relationships (
  fk_id serial NOT NULL,
  from_table varchar(255) NOT NULL,
  to_table varchar(255) NOT NULL,
  from_field varchar(255) NOT NULL,
  to_field varchar(255) NOT NULL,
  on_update varchar(255) NOT NULL,
  on_delete varchar(255) NOT NULL,
  PRIMARY KEY (fk_id)
);

DROP TABLE IF EXISTS kuu_geo_zones CASCADE;
CREATE TABLE kuu_geo_zones (
  geo_zone_id serial NOT NULL,
  geo_zone_name varchar(255) NOT NULL,
  geo_zone_description varchar(255) NOT NULL,
  last_modified timestamp(0),
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (geo_zone_id)
);

DROP TABLE IF EXISTS kuu_languages CASCADE;
CREATE TABLE kuu_languages (
  languages_id serial NOT NULL,
  name varchar(255) NOT NULL,
  code char(5) NOT NULL,
  locale varchar(255) NOT NULL,
  charset varchar(32) NOT NULL,
  date_format_short varchar(32) NOT NULL,
  date_format_long varchar(32) NOT NULL,
  time_format varchar(32) NOT NULL,
  text_direction varchar(12) NOT NULL,
  currencies_id integer NOT NULL,
  numeric_separator_decimal varchar(12) NOT NULL,
  numeric_separator_thousands varchar(12) NOT NULL,
  parent_id integer DEFAULT 0,
  sort_order integer,
  PRIMARY KEY (languages_id)
);

CREATE INDEX kuu_languages_code_idx ON kuu_languages USING btree (code);
CREATE INDEX kuu_languages_currencies_id_idx ON kuu_languages USING btree (currencies_id);
CREATE INDEX kuu_languages_parent_id_idx ON kuu_languages USING btree (parent_id);

DROP TABLE IF EXISTS kuu_languages_definitions CASCADE;
CREATE TABLE kuu_languages_definitions (
  id serial NOT NULL,
  languages_id integer NOT NULL,
  content_group varchar(255) NOT NULL,
  definition_key varchar(255) NOT NULL,
  definition_value text NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_languages_definitions_languages_id_idx ON kuu_languages_definitions USING btree (languages_id);
CREATE INDEX kuu_languages_definitions_content_group_idx ON kuu_languages_definitions USING btree (content_group);

DROP TABLE IF EXISTS kuu_manufacturers CASCADE;
CREATE TABLE kuu_manufacturers (
  manufacturers_id serial NOT NULL,
  manufacturers_name varchar(255) NOT NULL,
  manufacturers_image varchar(255),
  date_added timestamp(0),
  last_modified timestamp(0),
  PRIMARY KEY (manufacturers_id)
);

CREATE INDEX kuu_manufacturers_manufacturers_name_idx ON kuu_manufacturers USING btree (manufacturers_name);

DROP TABLE IF EXISTS kuu_manufacturers_info CASCADE;
CREATE TABLE kuu_manufacturers_info (
  manufacturers_id integer NOT NULL,
  languages_id integer NOT NULL,
  manufacturers_url varchar(255) NOT NULL,
  url_clicked integer DEFAULT 0,
  date_last_click timestamp(0),
  PRIMARY KEY (manufacturers_id, languages_id)
);

CREATE INDEX kuu_manufacturers_info_manufacturers_id_idx ON kuu_manufacturers_info USING btree (manufacturers_id);
CREATE INDEX kuu_manufacturers_info_languages_id_idx ON kuu_manufacturers_info USING btree (languages_id);

DROP TABLE IF EXISTS kuu_modules CASCADE;
CREATE TABLE kuu_modules (
  id serial NOT NULL,
  title varchar(255) NOT NULL,
  code varchar(255) NOT NULL,
  author_name varchar(255) NOT NULL,
  author_www varchar(255),
  modules_group varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS kuu_newsletters CASCADE;
CREATE TABLE kuu_newsletters (
  newsletters_id serial NOT NULL,
  title varchar(255) NOT NULL,
  content text NOT NULL,
  module varchar(255) NOT NULL,
  date_added timestamp(0) NOT NULL,
  date_sent timestamp(0),
  status integer,
  locked integer DEFAULT 0,
  PRIMARY KEY (newsletters_id)
);

DROP TABLE IF EXISTS kuu_newsletters_log CASCADE;
CREATE TABLE kuu_newsletters_log (
  newsletters_id integer NOT NULL,
  email_address varchar(255) NOT NULL,
  date_sent timestamp(0)
);

CREATE INDEX kuu_newsletters_log_newsletters_id_idx ON kuu_newsletters_log USING btree (newsletters_id);
CREATE INDEX kuu_newsletters_log_email_address_idx ON kuu_newsletters_log USING btree (email_address);

DROP TABLE IF EXISTS kuu_orders CASCADE;
CREATE TABLE kuu_orders (
  orders_id serial NOT NULL,
  customers_id integer,
  customers_name varchar(255) NOT NULL,
  customers_company varchar(255),
  customers_street_address varchar(255) NOT NULL,
  customers_suburb varchar(255),
  customers_city varchar(255) NOT NULL,
  customers_postcode varchar(255),
  customers_state varchar(255),
  customers_state_code varchar(255),
  customers_country varchar(255) NOT NULL,
  customers_country_iso2 char(2) NOT NULL,
  customers_country_iso3 char(3) NOT NULL,
  customers_telephone varchar(255),
  customers_email_address varchar(255) NOT NULL,
  customers_address_format varchar(255) NOT NULL,
  customers_ip_address varchar(15),
  delivery_name varchar(255) NOT NULL,
  delivery_company varchar(255),
  delivery_street_address varchar(255) NOT NULL,
  delivery_suburb varchar(255),
  delivery_city varchar(255) NOT NULL,
  delivery_postcode varchar(255),
  delivery_state varchar(255),
  delivery_state_code varchar(255),
  delivery_country varchar(255) NOT NULL,
  delivery_country_iso2 char(2) NOT NULL,
  delivery_country_iso3 char(3) NOT NULL,
  delivery_address_format varchar(255) NOT NULL,
  billing_name varchar(255) NOT NULL,
  billing_company varchar(255),
  billing_street_address varchar(255) NOT NULL,
  billing_suburb varchar(255),
  billing_city varchar(255) NOT NULL,
  billing_postcode varchar(255),
  billing_state varchar(255),
  billing_state_code varchar(255),
  billing_country varchar(255) NOT NULL,
  billing_country_iso2 char(2) NOT NULL,
  billing_country_iso3 char(3) NOT NULL,
  billing_address_format varchar(255) NOT NULL,
  payment_method varchar(255) NOT NULL,
  payment_module varchar(255) NOT NULL,
  last_modified timestamp(0),
  date_purchased timestamp(0),
  orders_status integer NOT NULL,
  orders_date_finished timestamp(0),
  currency char(3),
  currency_value numeric(14,6),
  PRIMARY KEY (orders_id)
);

CREATE INDEX kuu_orders_customers_id_idx ON kuu_orders USING btree (customers_id);
CREATE INDEX kuu_orders_orders_status_idx ON kuu_orders USING btree (orders_status);

DROP TABLE IF EXISTS kuu_orders_products CASCADE;
CREATE TABLE kuu_orders_products (
  orders_products_id serial NOT NULL,
  orders_id integer NOT NULL,
  products_id integer NOT NULL,
  products_model varchar(255),
  products_name varchar(255) NOT NULL,
  products_price numeric(15,4) NOT NULL,
  products_tax numeric(7,4) NOT NULL,
  products_quantity integer NOT NULL,
  PRIMARY KEY (orders_products_id)
);

CREATE INDEX kuu_orders_products_orders_id_idx ON kuu_orders_products USING btree (orders_id);
CREATE INDEX kuu_orders_products_products_id_idx ON kuu_orders_products USING btree (products_id);

DROP TABLE IF EXISTS kuu_orders_products_download CASCADE;
CREATE TABLE kuu_orders_products_download (
  orders_products_download_id serial NOT NULL,
  orders_id integer NOT NULL,
  orders_products_id integer NOT NULL,
  orders_products_filename varchar(255) NOT NULL,
  download_maxdays integer NOT NULL,
  download_count integer NOT NULL,
  PRIMARY KEY (orders_products_download_id)
);

CREATE INDEX kuu_orders_products_download_orders_id_idx ON kuu_orders_products_download USING btree (orders_id);
CREATE INDEX kuu_orders_products_download_orders_products_id_idx ON kuu_orders_products_download USING btree (orders_products_id);

DROP TABLE IF EXISTS kuu_orders_products_variants CASCADE;
CREATE TABLE kuu_orders_products_variants (
  id serial NOT NULL,
  orders_id integer NOT NULL,
  orders_products_id integer NOT NULL,
  group_title varchar(255) NOT NULL,
  value_title text NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_orders_products_variants_orders_id_idx ON kuu_orders_products_variants USING btree (orders_id);
CREATE INDEX kuu_orders_products_variants_orders_products_id_idx ON kuu_orders_products_variants USING btree (orders_products_id);

DROP TABLE IF EXISTS kuu_orders_status CASCADE;
CREATE TABLE kuu_orders_status (
  orders_status_id integer NOT NULL,
  language_id integer NOT NULL,
  orders_status_name varchar(255) NOT NULL,
  PRIMARY KEY (orders_status_id, language_id)
);

CREATE INDEX kuu_orders_status_language_id_idx ON kuu_orders_status USING btree (language_id);
CREATE INDEX kuu_orders_status_orders_status_name_idx ON kuu_orders_status USING btree (orders_status_name);

DROP TABLE IF EXISTS kuu_orders_status_history CASCADE;
CREATE TABLE kuu_orders_status_history (
  orders_status_history_id serial NOT NULL,
  orders_id integer NOT NULL,
  orders_status_id integer NOT NULL,
  date_added timestamp(0) NOT NULL,
  customer_notified integer DEFAULT 0,
  comments text,
  PRIMARY KEY (orders_status_history_id)
);

CREATE INDEX kuu_orders_status_history_orders_id_idx ON kuu_orders_status_history USING btree (orders_id);
CREATE INDEX kuu_orders_status_history_orders_status_id_idx ON kuu_orders_status_history USING btree (orders_status_id);

DROP TABLE IF EXISTS kuu_orders_total CASCADE;
CREATE TABLE kuu_orders_total (
  orders_total_id serial NOT NULL,
  orders_id integer NOT NULL,
  title varchar(255) NOT NULL,
  text varchar(255) NOT NULL,
  value numeric(15,4) NOT NULL,
  class varchar(255) NOT NULL,
  sort_order integer NOT NULL,
  PRIMARY KEY (orders_total_id)
);

CREATE INDEX kuu_orders_total_orders_id_idx ON kuu_orders_total USING btree (orders_id);

DROP TABLE IF EXISTS kuu_orders_transactions_history CASCADE;
CREATE TABLE kuu_orders_transactions_history (
  id serial NOT NULL,
  orders_id integer NOT NULL,
  transaction_code integer NOT NULL,
  transaction_return_value text NOT NULL,
  transaction_return_status integer NOT NULL,
  date_added timestamp(0),
  PRIMARY KEY (id)
);

CREATE INDEX kuu_orders_transactions_history_orders_id_idx ON kuu_orders_transactions_history USING btree (orders_id);

DROP TABLE IF EXISTS kuu_orders_transactions_status CASCADE;
CREATE TABLE kuu_orders_transactions_status (
  id integer NOT NULL,
  language_id integer NOT NULL,
  status_name varchar(255) NOT NULL,
  PRIMARY KEY (id, language_id)
);

CREATE INDEX kuu_orders_transactions_status_status_name_idx ON kuu_orders_transactions_status USING btree (status_name);
CREATE INDEX kuu_orders_transactions_status_language_id_idx ON kuu_orders_transactions_status USING btree (language_id);

DROP TABLE IF EXISTS kuu_product_attributes CASCADE;
CREATE TABLE kuu_product_attributes (
  id integer NOT NULL,
  products_id integer NOT NULL,
  languages_id integer NOT NULL,
  value text NOT NULL
);

CREATE INDEX kuu_product_attributes_id_products_id_idx ON kuu_product_attributes USING btree (id, products_id);
CREATE INDEX kuu_product_attributes_products_id_idx ON kuu_product_attributes USING btree (products_id);
CREATE INDEX kuu_product_attributes_languages_id_idx ON kuu_product_attributes USING btree (languages_id);

DROP TABLE IF EXISTS kuu_product_types CASCADE;
CREATE TABLE kuu_product_types (
  id serial NOT NULL,
  title varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_product_types_title_idx ON kuu_product_types USING btree (title);

DROP TABLE IF EXISTS kuu_product_types_assignments CASCADE;
CREATE TABLE kuu_product_types_assignments (
  id serial NOT NULL,
  types_id integer NOT NULL,
  action varchar(255) NOT NULL,
  module varchar(255),
  sort_order smallint,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_product_types_assignments_types_id_idx ON kuu_product_types_assignments USING btree (types_id);
CREATE INDEX kuu_product_types_assignments_action_idx ON kuu_product_types_assignments USING btree (action);

DROP TABLE IF EXISTS kuu_products CASCADE;
CREATE TABLE kuu_products (
  products_id serial NOT NULL,
  parent_id integer,
  products_quantity integer NOT NULL,
  products_price numeric(15,4) NOT NULL,
  products_model varchar(255),
  products_date_added timestamp(0) NOT NULL,
  products_last_modified timestamp(0),
  products_weight numeric(5,2),
  products_weight_class integer,
  products_status smallint NOT NULL,
  products_tax_class_id integer,
  products_types_id integer,
  manufacturers_id integer,
  products_ordered integer NOT NULL DEFAULT 0,
  has_children integer DEFAULT 0,
  PRIMARY KEY (products_id)
);

CREATE INDEX kuu_products_parent_id_idx ON kuu_products USING btree (parent_id);
CREATE INDEX kuu_products_products_date_added_idx ON kuu_products USING btree (products_date_added);
CREATE INDEX kuu_products_products_weight_class_idx ON kuu_products USING btree (products_weight_class);
CREATE INDEX kuu_products_products_tax_class_id_idx ON kuu_products USING btree (products_tax_class_id);
CREATE INDEX kuu_products_manufacturers_id_idx ON kuu_products USING btree (manufacturers_id);
CREATE INDEX kuu_products_products_types_id_idx ON kuu_products USING btree (products_types_id);

DROP TABLE IF EXISTS kuu_products_description CASCADE;
CREATE TABLE kuu_products_description (
  products_id serial NOT NULL,
  language_id integer NOT NULL,
  products_name varchar(255) NOT NULL,
  products_description text,
  products_keyword varchar(255),
  products_tags varchar(255),
  products_url varchar(255),
  products_viewed integer DEFAULT 0,
  PRIMARY KEY (products_id, language_id)
);

CREATE INDEX kuu_products_description_products_id_idx ON kuu_products_description USING btree (products_id);
CREATE INDEX kuu_products_description_language_id_idx ON kuu_products_description USING btree (language_id);
CREATE INDEX kuu_products_products_name_idx ON kuu_products_description USING btree (products_name);
CREATE INDEX kuu_products_products_keyword_idx ON kuu_products_description USING btree (products_keyword);

DROP TABLE IF EXISTS kuu_products_images CASCADE;
CREATE TABLE kuu_products_images (
  id serial NOT NULL,
  products_id integer NOT NULL,
  image varchar(255) NOT NULL,
  default_flag smallint NOT NULL,
  sort_order integer NOT NULL,
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_products_images_products_id_idx ON kuu_products_images USING btree (products_id);

DROP TABLE IF EXISTS kuu_products_images_groups CASCADE;
CREATE TABLE kuu_products_images_groups (
  id integer NOT NULL,
  language_id integer NOT NULL,
  title varchar(255) NOT NULL,
  code varchar(255) NOT NULL,
  size_width integer,
  size_height integer,
  force_size smallint DEFAULT 0,
  PRIMARY KEY (id, language_id)
);

CREATE INDEX kuu_products_images_groups_language_id_idx ON kuu_products_images_groups USING btree (language_id);

DROP TABLE IF EXISTS kuu_products_notifications CASCADE;
CREATE TABLE kuu_products_notifications (
  products_id integer NOT NULL,
  customers_id integer NOT NULL,
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (products_id, customers_id)
);

CREATE INDEX kuu_products_notifications_products_id_idx ON kuu_products_notifications USING btree (products_id);
CREATE INDEX kuu_products_notifications_customers_id_idx ON kuu_products_notifications USING btree (customers_id);

DROP TABLE IF EXISTS kuu_products_to_categories CASCADE;
CREATE TABLE kuu_products_to_categories (
  products_id integer NOT NULL,
  categories_id integer NOT NULL,
  PRIMARY KEY (products_id, categories_id)
);

CREATE INDEX kuu_products_to_categories_products_id_idx ON kuu_products_to_categories USING btree (products_id);
CREATE INDEX kuu_products_to_categories_categories_id_idx ON kuu_products_to_categories USING btree (categories_id);

DROP TABLE IF EXISTS kuu_products_variants CASCADE;
CREATE TABLE kuu_products_variants (
  products_id integer NOT NULL,
  products_variants_values_id integer NOT NULL,
  default_combo smallint DEFAULT 0,
  PRIMARY KEY (products_id, products_variants_values_id)
);

CREATE INDEX kuu_products_variants_products_id_idx ON kuu_products_variants USING btree (products_id);
CREATE INDEX kuu_products_variants_products_variants_values_id_idx ON kuu_products_variants USING btree (products_variants_values_id);

DROP TABLE IF EXISTS kuu_products_variants_groups CASCADE;
CREATE TABLE kuu_products_variants_groups (
  id serial NOT NULL,
  languages_id integer NOT NULL,
  title varchar(255) NOT NULL,
  sort_order integer NOT NULL,
  module varchar(255) NOT NULL,
  PRIMARY KEY (id, languages_id)
);

CREATE INDEX kuu_products_variants_groups_languages_id_idx ON kuu_products_variants_groups USING btree (languages_id);

DROP TABLE IF EXISTS kuu_products_variants_values CASCADE;
CREATE TABLE kuu_products_variants_values (
  id serial NOT NULL,
  languages_id integer NOT NULL,
  products_variants_groups_id integer NOT NULL,
  title varchar(255) NOT NULL,
  sort_order integer NOT NULL,
  PRIMARY KEY (id, languages_id)
);

CREATE INDEX kuu_products_variants_values_languages_id_idx ON kuu_products_variants_values USING btree (languages_id);
CREATE INDEX kuu_products_variants_values_products_variants_groups_id_idx ON kuu_products_variants_values USING btree (products_variants_groups_id);

DROP TABLE IF EXISTS kuu_reviews CASCADE;
CREATE TABLE kuu_reviews (
  reviews_id serial NOT NULL,
  products_id integer NOT NULL,
  customers_id integer,
  customers_name varchar(255) NOT NULL,
  reviews_rating integer,
  languages_id integer NOT NULL,
  reviews_text text NOT NULL,
  date_added timestamp(0),
  last_modified timestamp(0),
  reviews_read integer NOT NULL DEFAULT '0',
  reviews_status smallint NOT NULL,
  PRIMARY KEY (reviews_id)
);

CREATE INDEX kuu_reviews_products_id_idx ON kuu_reviews USING btree (products_id);
CREATE INDEX kuu_reviews_customers_id_idx ON kuu_reviews USING btree (customers_id);
CREATE INDEX kuu_reviews_languages_id_idx ON kuu_reviews USING btree (languages_id);

DROP TABLE IF EXISTS kuu_sessions CASCADE;
CREATE TABLE kuu_sessions (
  id char(128) NOT NULL,
  expiry integer NOT NULL,
  value text NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS kuu_shipping_availability CASCADE;
CREATE TABLE kuu_shipping_availability (
  id integer NOT NULL,
  languages_id integer NOT NULL,
  title varchar(255) NOT NULL,
  css_key varchar(255),
  PRIMARY KEY (id, languages_id)
);

CREATE INDEX kuu_shipping_availability_languages_id_idx ON kuu_shipping_availability USING btree (languages_id);

DROP TABLE IF EXISTS kuu_shopping_carts CASCADE;
CREATE TABLE kuu_shopping_carts (
  customers_id integer NOT NULL,
  item_id smallint NOT NULL,
  products_id integer NOT NULL,
  quantity smallint NOT NULL,
  date_added timestamp(0)
);

CREATE INDEX kuu_shopping_carts_customers_id_idx ON kuu_shopping_carts USING btree (customers_id);
CREATE INDEX kuu_shopping_carts_customers_id_products_id_idx ON kuu_shopping_carts USING btree (customers_id, products_id);
CREATE INDEX kuu_shopping_carts_products_id_idx ON kuu_shopping_carts USING btree (products_id);

DROP TABLE IF EXISTS kuu_shopping_carts_custom_variants_values CASCADE;
CREATE TABLE kuu_shopping_carts_custom_variants_values (
  shopping_carts_item_id smallint NOT NULL,
  customers_id integer NOT NULL,
  products_id integer NOT NULL,
  products_variants_values_id integer NOT NULL,
  products_variants_values_text text NOT NULL
);

CREATE INDEX kuu_shopping_carts_custom_variants_values_cid_pid_idx ON kuu_shopping_carts_custom_variants_values USING btree (customers_id, products_id);
CREATE INDEX kuu_shopping_carts_custom_variants_values_customers_id_idx ON kuu_shopping_carts_custom_variants_values USING btree (customers_id);
CREATE INDEX kuu_shopping_carts_custom_variants_values_products_id_idx ON kuu_shopping_carts_custom_variants_values USING btree (products_id);
CREATE INDEX kuu_shopping_carts_custom_variants_values_pvvid_idx ON kuu_shopping_carts_custom_variants_values USING btree (products_variants_values_id);

DROP TABLE IF EXISTS kuu_specials CASCADE;
CREATE TABLE kuu_specials (
  specials_id serial NOT NULL,
  products_id integer NOT NULL,
  specials_new_products_price numeric(15,4) NOT NULL,
  specials_date_added timestamp(0),
  specials_last_modified timestamp(0),
  start_date timestamp(0),
  expires_date timestamp(0),
  date_status_change timestamp(0),
  status smallint NOT NULL DEFAULT '1',
  PRIMARY KEY (specials_id)
);

CREATE INDEX kuu_specials_products_id_idx ON kuu_specials USING btree (products_id);

DROP TABLE IF EXISTS kuu_tax_class CASCADE;
CREATE TABLE kuu_tax_class (
  tax_class_id serial NOT NULL,
  tax_class_title varchar(255) NOT NULL,
  tax_class_description varchar(255) NOT NULL,
  last_modified timestamp(0),
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (tax_class_id)
);

DROP TABLE IF EXISTS kuu_tax_rates CASCADE;
CREATE TABLE kuu_tax_rates (
  tax_rates_id serial NOT NULL,
  tax_zone_id integer NOT NULL,
  tax_class_id integer NOT NULL,
  tax_priority int DEFAULT 1,
  tax_rate numeric(7,4) NOT NULL,
  tax_description varchar(255) NOT NULL,
  last_modified timestamp(0),
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (tax_rates_id)
);

CREATE INDEX kuu_tax_rates_tax_zone_id_idx ON kuu_tax_rates USING btree (tax_zone_id);
CREATE INDEX kuu_tax_rates_tax_class_id_idx ON kuu_tax_rates USING btree (tax_class_id);

DROP TABLE IF EXISTS kuu_templates CASCADE;
CREATE TABLE kuu_templates (
  id serial NOT NULL,
  title varchar(255) NOT NULL,
  code varchar(255) NOT NULL,
  author_name varchar(255) NOT NULL,
  author_www varchar(255),
  markup_version varchar(255),
  css_based smallint,
  medium varchar(255),
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS kuu_templates_boxes CASCADE;
CREATE TABLE kuu_templates_boxes (
  id serial NOT NULL,
  title varchar(255) NOT NULL,
  code varchar(255) NOT NULL,
  author_name varchar(255) NOT NULL,
  author_www varchar(255),
  modules_group varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS kuu_templates_boxes_to_pages CASCADE;
CREATE TABLE kuu_templates_boxes_to_pages (
  id serial NOT NULL,
  templates_boxes_id integer NOT NULL,
  templates_id integer NOT NULL,
  content_page varchar(255) NOT NULL,
  boxes_group varchar(32) NOT NULL,
  sort_order integer DEFAULT 0,
  page_specific integer DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE INDEX kuu_templates_boxes_to_pages_tbid_tid_cpage_bgroup_idx ON kuu_templates_boxes_to_pages USING btree (templates_boxes_id, templates_id, content_page, boxes_group);
CREATE INDEX kuu_templates_boxes_to_pages_templates_boxes_id_idx ON kuu_templates_boxes_to_pages USING btree (templates_boxes_id);
CREATE INDEX kuu_templates_boxes_to_pages_templates_id_idx ON kuu_templates_boxes_to_pages USING btree (templates_id);

DROP TABLE IF EXISTS kuu_weight_classes CASCADE;
CREATE TABLE kuu_weight_classes (
  weight_class_id integer NOT NULL,
  weight_class_key varchar(4) NOT NULL,
  language_id integer NOT NULL,
  weight_class_title varchar(255) NOT NULL,
  PRIMARY KEY (weight_class_id, language_id)
);

CREATE INDEX kuu_weight_classes_language_id_idx ON kuu_weight_classes USING btree (language_id);

DROP TABLE IF EXISTS kuu_weight_classes_rules CASCADE;
CREATE TABLE kuu_weight_classes_rules (
  weight_class_from_id integer NOT NULL,
  weight_class_to_id integer NOT NULL,
  weight_class_rule numeric(15,4) NOT NULL,
  PRIMARY KEY (weight_class_from_id, weight_class_to_id)
);

CREATE INDEX kuu_weight_classes_rules_weight_class_from_id_idx ON kuu_weight_classes_rules USING btree (weight_class_from_id);
CREATE INDEX kuu_weight_classes_rules_weight_class_to_id_idx ON kuu_weight_classes_rules USING btree (weight_class_to_id);

DROP TABLE IF EXISTS kuu_whos_online CASCADE;
CREATE TABLE kuu_whos_online (
  customer_id integer,
  full_name varchar(255) NOT NULL,
  session_id varchar(128) NOT NULL,
  ip_address varchar(15) NOT NULL,
  time_entry varchar(14) NOT NULL,
  time_last_click varchar(14) NOT NULL,
  last_page_url text NOT NULL
);

CREATE INDEX kuu_whos_online_customer_id_idx ON kuu_whos_online USING btree (customer_id);
CREATE INDEX kuu_whos_online_full_name_idx ON kuu_whos_online USING btree (full_name);
CREATE INDEX kuu_whos_online_time_last_click_idx ON kuu_whos_online USING btree (time_last_click);

DROP TABLE IF EXISTS kuu_zones CASCADE;
CREATE TABLE kuu_zones (
  zone_id serial NOT NULL,
  zone_country_id integer NOT NULL,
  zone_code varchar(255) NOT NULL,
  zone_name varchar(255) NOT NULL,
  PRIMARY KEY (zone_id)
);

CREATE INDEX kuu_zones_zone_country_id_idx ON kuu_zones USING btree (zone_country_id);
CREATE INDEX kuu_zones_zone_code_idx ON kuu_zones USING btree (zone_code);
CREATE INDEX kuu_zones_zone_name_idx ON kuu_zones USING btree (zone_name);

DROP TABLE IF EXISTS kuu_zones_to_geo_zones CASCADE;
CREATE TABLE kuu_zones_to_geo_zones (
  association_id serial NOT NULL,
  zone_country_id integer NOT NULL,
  zone_id integer,
  geo_zone_id integer NOT NULL,
  last_modified timestamp(0),
  date_added timestamp(0) NOT NULL,
  PRIMARY KEY (association_id)
);

CREATE INDEX kuu_zones_to_geo_zones_zone_country_id_idx ON kuu_zones_to_geo_zones USING btree (zone_country_id);
CREATE INDEX kuu_zones_to_geo_zones_zone_id_idx ON kuu_zones_to_geo_zones USING btree (zone_id);
CREATE INDEX kuu_zones_to_geo_zones_geo_zone_id_idx ON kuu_zones_to_geo_zones USING btree (geo_zone_id);

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Store Name', 'STORE_NAME', 'Kuuzu', 'The name of my store', '1', '1', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Store Owner', 'STORE_OWNER', 'Store Owner', 'The name of my store owner', '1', '2', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('E-Mail Address', 'STORE_OWNER_EMAIL_ADDRESS', 'root@localhost', 'The e-mail address of my store owner', '1', '3', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('E-Mail From', 'EMAIL_FROM', '"Store Owner" <root@localhost>', 'The e-mail address used in (sent) e-mails', '1', '4', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Country', 'STORE_COUNTRY', '223', 'The country my store is located in <br><br><b>Note: Please remember to update the store zone.</b>', '1', '6', E'Kuuzu\\KU\\Core\\Site\\Shop\\Address::getCountryName', 'kuu_cfg_set_countries_pulldown_menu', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Zone', 'STORE_ZONE', '4031', 'The zone my store is located in', '1', '7', E'Kuuzu\\KU\\Core\\Site\\Shop\\Address::getZoneName', 'kuu_cfg_set_zones_pulldown_menu', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Extra Order Emails To', 'SEND_EXTRA_ORDER_EMAILS_TO', null, 'Send extra order emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '1', '11', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Allow Guest To Tell A Friend', 'ALLOW_GUEST_TO_TELL_A_FRIEND', '-1', 'Allow guests to tell a friend about a product', '1', '15', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Store Address and Phone', 'STORE_NAME_ADDRESS', E'Store Name\nAddress\nCountry\nPhone', 'This is the Store Name, Address and Phone used on printable documents and displayed online', '1', '18', 'kuu_cfg_set_textarea_field', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Tax Decimal Places', 'TAX_DECIMAL_PLACES', '0', 'Pad the tax value this amount of decimal places', '1', '20', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Display Prices with Tax', 'DISPLAY_PRICE_WITH_TAX', '-1', 'Display prices with tax included (true) or add the tax at the end (false)', '1', '21', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Credit Card Owner Name', 'CC_OWNER_MIN_LENGTH', '3', 'Minimum length of credit card owner name', '2', '12', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Credit Card Number', 'CC_NUMBER_MIN_LENGTH', '10', 'Minimum length of credit card number', '2', '13', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Review Text', 'REVIEW_TEXT_MIN_LENGTH', '50', 'Minimum length of review text', '2', '14', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Address Book Entries', 'MAX_ADDRESS_BOOK_ENTRIES', '5', 'Maximum address book entries a customer is allowed to have', '3', '1', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Search Results', 'MAX_DISPLAY_SEARCH_RESULTS', '20', 'Amount of products to list', '3', '2', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Page Links', 'MAX_DISPLAY_PAGE_LINKS', '5', 'Number of ''number'' links use for page-sets', '3', '3', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Categories To List Per Row', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 'How many categories to list per row', '3', '13', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('New Products Listing', 'MAX_DISPLAY_PRODUCTS_NEW', '10', 'Maximum number of new products to display in new products page', '3', '14', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Order History', 'MAX_DISPLAY_ORDER_HISTORY', '10', 'Maximum number of orders to display in the order history page', '3', '18', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Heading Image Width', 'HEADING_IMAGE_WIDTH', '57', 'The pixel width of heading images', '4', '3', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Heading Image Height', 'HEADING_IMAGE_HEIGHT', '40', 'The pixel height of heading images', '4', '4', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Image Required', 'IMAGE_REQUIRED', '1', 'Enable to display broken images. Good for development.', '4', '8', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Gender', 'ACCOUNT_GENDER', '1', 'Ask for or require the customers gender.', '5', '10', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, 0, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('First Name', 'ACCOUNT_FIRST_NAME', '2', 'Minimum requirement for the customers first name.', '5', '11', 'kuu_cfg_set_boolean_value(array(''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Last Name', 'ACCOUNT_LAST_NAME', '2', 'Minimum requirement for the customers last name.', '5', '12', 'kuu_cfg_set_boolean_value(array(''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Date Of Birth', 'ACCOUNT_DATE_OF_BIRTH', '1', 'Ask for the customers date of birth.', '5', '13', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('E-Mail Address', 'ACCOUNT_EMAIL_ADDRESS', '6', 'Minimum requirement for the customers e-mail address.', '5', '14', 'kuu_cfg_set_boolean_value(array(''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Password', 'ACCOUNT_PASSWORD', '5', 'Minimum requirement for the customers password.', '5', '15', 'kuu_cfg_set_boolean_value(array(''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Newsletter', 'ACCOUNT_NEWSLETTER', '1', 'Ask for a newsletter subscription.', '5', '16', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Company Name', 'ACCOUNT_COMPANY', '0', 'Ask for or require the customers company name.', '5', '17', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(''10'', ''9'', ''8'', ''7'', ''6'', ''5'', ''4'', ''3'', ''2'', ''1'', 0, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Street Address', 'ACCOUNT_STREET_ADDRESS', '5', 'Minimum requirement for the customers street address.', '5', '18', 'kuu_cfg_set_boolean_value(array(''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Suburb', 'ACCOUNT_SUBURB', '0', 'Ask for or require the customers suburb.', '5', '19', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(''10'', ''9'', ''8'', ''7'', ''6'', ''5'', ''4'', ''3'', ''2'', ''1'', 0, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Post Code', 'ACCOUNT_POST_CODE', '0', 'Minimum requirement for the customers post code.', '5', '20', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(-1, 0, ''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('City', 'ACCOUNT_CITY', '4', 'Minimum requirement for the customers city.', '5', '21', 'kuu_cfg_set_boolean_value(array(''1'', ''2'', ''3'', ''4'', ''5'', ''6'', ''7'', ''8'', ''9'', ''10''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('State', 'ACCOUNT_STATE', '2', 'Ask for or require the customers state.', '5', '22', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(''10'', ''9'', ''8'', ''7'', ''6'', ''5'', ''4'', ''3'', ''2'', ''1'', 0, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Country', 'ACCOUNT_COUNTRY', '1', 'Ask for the customers country.', '5', '23', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Telephone Number', 'ACCOUNT_TELEPHONE', '3', 'Ask for or require the customers telephone number.', '5', '24', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(''10'', ''9'', ''8'', ''7'', ''6'', ''5'', ''4'', ''3'', ''2'', ''1'', 0, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Fax Number', 'ACCOUNT_FAX', '0', 'Ask for or require the customers fax number.', '5', '25', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(''10'', ''9'', ''8'', ''7'', ''6'', ''5'', ''4'', ''3'', ''2'', ''1'', 0, -1))', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Currency', 'DEFAULT_CURRENCY', 'USD', 'Default Currency', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Language', 'DEFAULT_LANGUAGE', 'en_US', 'Default Language', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Order Status For New Orders', 'DEFAULT_ORDERS_STATUS_ID', '1', 'When a new order is created, this order status will be assigned to it.', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Image Group', 'DEFAULT_IMAGE_GROUP_ID', '2', 'Default image group.', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Template', 'DEFAULT_TEMPLATE', 'kuuzu', 'Default Template', '6', '0', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Country of Origin', 'SHIPPING_ORIGIN_COUNTRY', '223', 'Select the country of origin to be used in shipping quotes.', '7', '1', E'Kuuzu\\KU\\Core\\Site\\Shop\\Address::getCountryName', 'kuu_cfg_set_countries_pulldown_menu', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Postal Code', 'SHIPPING_ORIGIN_ZIP', 'NONE', 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.', '7', '2', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Enter the Maximum Package Weight you will ship', 'SHIPPING_MAX_WEIGHT', '50', 'Carriers have a max weight limit for a single package. This is a common one for all.', '7', '3', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Package Tare weight.', 'SHIPPING_BOX_WEIGHT', '3', 'What is the weight of typical packaging of small to medium packages?', '7', '4', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Larger packages - percentage increase.', 'SHIPPING_BOX_PADDING', '10', 'For 10% enter 10', '7', '5', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Default Shipping Unit', 'SHIPPING_WEIGHT_UNIT',2, 'Select the unit of weight to be used for shipping.', '7', '6', E'Kuuzu\\KU\\Core\\Site\\Shop\\Weight::getTitle', 'kuu_cfg_set_weight_classes_pulldown_menu', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Image', 'PRODUCT_LIST_IMAGE', '1', 'Do you want to display the Product Image?', '8', '1', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Manufaturer Name','PRODUCT_LIST_MANUFACTURER', '0', 'Do you want to display the Product Manufacturer Name?', '8', '2', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Model', 'PRODUCT_LIST_MODEL', '0', 'Do you want to display the Product Model?', '8', '3', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Name', 'PRODUCT_LIST_NAME', '2', 'Do you want to display the Product Name?', '8', '4', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Price', 'PRODUCT_LIST_PRICE', '3', 'Do you want to display the Product Price', '8', '5', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Quantity', 'PRODUCT_LIST_QUANTITY', '0', 'Do you want to display the Product Quantity?', '8', '6', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Weight', 'PRODUCT_LIST_WEIGHT', '0', 'Do you want to display the Product Weight?', '8', '7', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Buy Now column', 'PRODUCT_LIST_BUY_NOW', '4', 'Do you want to display the Buy Now column?', '8', '8', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Category/Manufacturer Filter (0=disable; 1=enable)', 'PRODUCT_LIST_FILTER', '1', 'Do you want to display the Category/Manufacturer Filter?', '8', '9', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Location of Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 'PREV_NEXT_BAR_LOCATION', '2', 'Sets the location of the Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', '8', '10', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Check stock level', 'STOCK_CHECK', '1', 'Check to see if sufficent stock is available', '9', '1', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Subtract stock', 'STOCK_LIMITED', '1', 'Subtract product in stock by product orders', '9', '2', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Allow Checkout', 'STOCK_ALLOW_CHECKOUT', '1', 'Allow customer to checkout even if there is insufficient stock', '9', '3', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Mark product out of stock', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 'Display something on screen so customer can see which product has insufficient stock', '9', '4', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Stock Re-order level', 'STOCK_REORDER_LEVEL', '5', 'Define when stock needs to be re-ordered', '9', '5', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('E-Mail Transport Method', 'EMAIL_TRANSPORT', 'sendmail', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.', '12', '1', 'kuu_cfg_set_boolean_value(array(''sendmail'', ''smtp''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('E-Mail Linefeeds', 'EMAIL_LINEFEED', 'LF', 'Defines the character sequence used to separate mail headers.', '12', '2', 'kuu_cfg_set_boolean_value(array(''LF'', ''CRLF''))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Use MIME HTML When Sending Emails', 'EMAIL_USE_HTML', '-1', 'Send e-mails in HTML format', '12', '3', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Verify E-Mail Addresses Through DNS', 'ENTRY_EMAIL_ADDRESS_CHECK', '-1', 'Verify e-mail address through a DNS server', '12', '4', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Send E-Mails', 'SEND_EMAILS', '1', 'Send out e-mails', '12', '5', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Enable download', 'DOWNLOAD_ENABLED', '-1', 'Enable the products download functions.', '13', '1', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Download by redirect', 'DOWNLOAD_BY_REDIRECT', '-1', 'Use browser redirection for download. Disable on non-Unix systems.', '13', '2', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Expiry delay (days)' ,'DOWNLOAD_MAX_DAYS', '7', 'Set number of days before the download link expires. 0 means no limit.', '13', '3', null, now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Maximum number of downloads' ,'DOWNLOAD_MAX_COUNT', '5', 'Set the maximum number of downloads. 0 means no download authorized.', '13', '4', null, now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Confirm Terms and Conditions During Checkout Procedure', 'DISPLAY_CONDITIONS_ON_CHECKOUT', '-1', 'Show the Terms and Conditions during the checkout procedure which the customer must agree to.', '16', '1', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Confirm Privacy Notice During Account Creation Procedure', 'DISPLAY_PRIVACY_CONDITIONS', '-1', 'Show the Privacy Notice during the account creation procedure which the customer must agree to.', '16', '2', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Verify With Regular Expressions', 'CFG_CREDIT_CARDS_VERIFY_WITH_REGEXP', '1', 'Verify credit card numbers with server-side regular expression patterns.', '17', '0', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Verify With Javascript', 'CFG_CREDIT_CARDS_VERIFY_WITH_JS', '1', 'Verify credit card numbers with javascript based regular expression patterns.', '17', '1', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('GZIP', 'CFG_APP_GZIP', '/usr/bin/gzip', 'The program location to gzip.', '18', '1', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('GUNZIP', 'CFG_APP_GUNZIP', '/usr/bin/gunzip', 'The program location to gunzip.', '18', '2', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('ZIP', 'CFG_APP_ZIP', '/usr/bin/zip', 'The program location to zip.', '18', '3', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('UNZIP', 'CFG_APP_UNZIP', '/usr/bin/unzip', 'The program location to unzip.', '18', '4', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('cURL', 'CFG_APP_CURL', '/usr/bin/curl', 'The program location to cURL.', '18', '5', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('ImageMagick "convert"', 'CFG_APP_IMAGEMAGICK_CONVERT', '/usr/bin/convert', 'The program location to ImageMagicks "convert" to use when manipulating images.', '18', '6', now());

INSERT INTO kuu_configuration_group VALUES ('1', 'My Store', 'General information about my store', '1', '1');
INSERT INTO kuu_configuration_group VALUES ('2', 'Minimum Values', 'The minimum values for functions / data', '2', '1');
INSERT INTO kuu_configuration_group VALUES ('3', 'Maximum Values', 'The maximum values for functions / data', '3', '1');
INSERT INTO kuu_configuration_group VALUES ('4', 'Images', 'Image parameters', '4', '1');
INSERT INTO kuu_configuration_group VALUES ('5', 'Customer Details', 'Customer account configuration', '5', '1');
INSERT INTO kuu_configuration_group VALUES ('6', 'Module Options', 'Hidden from configuration', '6', '0');
INSERT INTO kuu_configuration_group VALUES ('7', 'Shipping/Packaging', 'Shipping options available at my store', '7', '1');
INSERT INTO kuu_configuration_group VALUES ('8', 'Product Listing', 'Product Listing configuration options', '8', '1');
INSERT INTO kuu_configuration_group VALUES ('9', 'Stock', 'Stock configuration options', '9', '1');
INSERT INTO kuu_configuration_group VALUES ('12', 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', '12', '1');
INSERT INTO kuu_configuration_group VALUES ('13', 'Download', 'Downloadable products options', '13', '1');
INSERT INTO kuu_configuration_group VALUES ('16', 'Regulations', 'Regulation options', '16', '1');
INSERT INTO kuu_configuration_group VALUES ('17', 'Credit Cards', 'Credit card options', '17', '1');
INSERT INTO kuu_configuration_group VALUES ('18', 'Program Locations', 'Locations to certain programs on the server.', '18', '1');

ALTER SEQUENCE kuu_configuration_group_configuration_group_id_seq RESTART 19;

INSERT INTO kuu_countries VALUES (1,'Afghanistan','AF','AFG',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'BDS','بد خشان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'BDG','بادغیس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'BGL','بغلان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'BAL','بلخ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'BAM','بامیان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'DAY','دایکندی');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'FRA','فراه');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'FYB','فارياب');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'GHA','غزنى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'GHO','غور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'HEL','هلمند');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'HER','هرات');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'JOW','جوزجان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'KAB','کابل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'KAN','قندھار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'KAP','کاپيسا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'KHO','خوست');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'KNR','کُنَر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'KDZ','كندوز');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'LAG','لغمان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'LOW','لوګر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'NAN','ننگرهار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'NIM','نیمروز');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'NUR','نورستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'ORU','ؤروزگان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'PIA','پکتیا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'PKA','پکتيکا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'PAN','پنج شیر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'PAR','پروان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'SAM','سمنگان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'SAR','سر پل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'TAK','تخار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'WAR','وردک');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (1,'ZAB','زابل');

INSERT INTO kuu_countries VALUES (2,'Albania','AL','ALB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'BR','Beratit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'BU','Bulqizës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'DI','Dibrës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'DL','Delvinës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'DR','Durrësit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'DV','Devollit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'EL','Elbasanit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'ER','Kolonjës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'FR','Fierit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'GJ','Gjirokastrës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'GR','Gramshit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'HA','Hasit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'KA','Kavajës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'KB','Kurbinit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'KC','Kuçovës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'KO','Korçës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'KR','Krujës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'KU','Kukësit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'LB','Librazhdit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'LE','Lezhës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'LU','Lushnjës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'MK','Mallakastrës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'MM','Malësisë së Madhe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'MR','Mirditës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'MT','Matit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'PG','Pogradecit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'PQ','Peqinit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'PR','Përmetit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'PU','Pukës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'SH','Shkodrës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'SK','Skraparit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'SR','Sarandës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'TE','Tepelenës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'TP','Tropojës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'TR','Tiranës');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (2,'VL','Vlorës');

INSERT INTO kuu_countries VALUES (3,'Algeria','DZ','DZA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'01','ولاية أدرار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'02','ولاية الشلف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'03','ولاية الأغواط');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'04','ولاية أم البواقي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'05','ولاية باتنة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'06','ولاية بجاية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'07','ولاية بسكرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'08','ولاية بشار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'09','البليدة‎');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'10','ولاية البويرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'11','ولاية تمنراست');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'12','ولاية تبسة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'13','تلمسان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'14','ولاية تيارت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'15','تيزي وزو');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'16','ولاية الجزائر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'17','ولاية عين الدفلى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'18','ولاية جيجل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'19','ولاية سطيف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'20','ولاية سعيدة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'21','السكيكدة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'22','ولاية سيدي بلعباس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'23','ولاية عنابة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'24','ولاية قالمة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'25','قسنطينة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'26','ولاية المدية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'27','ولاية مستغانم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'28','ولاية المسيلة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'29','ولاية معسكر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'30','ورقلة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'31','وهران');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'32','ولاية البيض');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'33','ولاية اليزي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'34','ولاية برج بوعريريج');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'35','ولاية بومرداس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'36','ولاية الطارف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'37','تندوف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'38','ولاية تسمسيلت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'39','ولاية الوادي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'40','ولاية خنشلة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'41','ولاية سوق أهراس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'42','ولاية تيبازة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'43','ولاية ميلة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'44','ولاية عين الدفلى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'45','ولاية النعامة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'46','ولاية عين تموشنت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'47','ولاية غرداية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (3,'48','ولاية غليزان');

INSERT INTO kuu_countries VALUES (4,'American Samoa','AS','ASM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (4,'EA','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (4,'MA','Manu''a');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (4,'RI','Rose Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (4,'SI','Swains Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (4,'WE','Western');

INSERT INTO kuu_countries VALUES (5,'Andorra','AD','AND',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'AN','Andorra la Vella');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'CA','Canillo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'EN','Encamp');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'LE','Escaldes-Engordany');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'LM','La Massana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'OR','Ordino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (5,'SJ','Sant Juliá de Lória');

INSERT INTO kuu_countries VALUES (6,'Angola','AO','AGO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'BGO','Bengo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'BGU','Benguela');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'BIE','Bié');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'CAB','Cabinda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'CCU','Cuando Cubango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'CNO','Cuanza Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'CUS','Cuanza Sul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'CNN','Cunene');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'HUA','Huambo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'HUI','Huíla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'LUA','Luanda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'LNO','Lunda Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'LSU','Lunda Sul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'MAL','Malanje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'MOX','Moxico');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'NAM','Namibe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'UIG','Uíge');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (6,'ZAI','Zaire');

INSERT INTO kuu_countries VALUES (7,'Anguilla','AI','AIA',null);
INSERT INTO kuu_countries VALUES (8,'Antarctica','AQ','ATA',null);

INSERT INTO kuu_countries VALUES (9,'Antigua and Barbuda','AG','ATG',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'BAR','Barbuda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'SGE','Saint George');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'SJO','Saint John');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'SMA','Saint Mary');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'SPA','Saint Paul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'SPE','Saint Peter');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (9,'SPH','Saint Philip');

INSERT INTO kuu_countries VALUES (10,'Argentina','AR','ARG',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'A','Salta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'B','Buenos Aires Province');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'C','Capital Federal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'D','San Luis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'E','Entre Ríos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'F','La Rioja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'G','Santiago del Estero');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'H','Chaco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'J','San Juan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'K','Catamarca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'L','La Pampa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'M','Mendoza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'N','Misiones');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'P','Formosa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'Q','Neuquén');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'R','Río Negro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'S','Santa Fe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'T','Tucumán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'U','Chubut');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'V','Tierra del Fuego');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'W','Corrientes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'X','Córdoba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'Y','Jujuy');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (10,'Z','Santa Cruz');

INSERT INTO kuu_countries VALUES (11,'Armenia','AM','ARM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'AG','Արագածոտն');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'AR','Արարատ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'AV','Արմավիր');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'ER','Երևան');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'GR','Գեղարքունիք');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'KT','Կոտայք');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'LO','Լոռի');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'SH','Շիրակ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'SU','Սյունիք');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'TV','Տավուշ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (11,'VD','Վայոց Ձոր');

INSERT INTO kuu_countries VALUES (12,'Aruba','AW','ABW',null);

INSERT INTO kuu_countries VALUES (13,'Australia','AU','AUS',E':name\n:street_address\n:suburb :state_code :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'ACT','Australian Capital Territory');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'NSW','New South Wales');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'NT','Northern Territory');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'QLD','Queensland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'SA','South Australia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'TAS','Tasmania');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'VIC','Victoria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (13,'WA','Western Australia');

INSERT INTO kuu_countries VALUES (14,'Austria','AT','AUT',E':name\n:street_address\nA-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'1','Burgenland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'2','Kärnten');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'3','Niederösterreich');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'4','Oberösterreich');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'5','Salzburg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'6','Steiermark');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'7','Tirol');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'8','Voralberg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (14,'9','Wien');

INSERT INTO kuu_countries VALUES (15,'Azerbaijan','AZ','AZE',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AB','Əli Bayramlı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'ABS','Abşeron');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AGC','Ağcabədi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AGM','Ağdam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AGS','Ağdaş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AGA','Ağstafa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AGU','Ağsu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'AST','Astara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'BA','Bakı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'BAB','Babək');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'BAL','Balakən');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'BAR','Bərdə');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'BEY','Beyləqan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'BIL','Biləsuvar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'CAB','Cəbrayıl');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'CAL','Cəlilabab');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'CUL','Julfa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'DAS','Daşkəsən');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'DAV','Dəvəçi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'FUZ','Füzuli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'GA','Gəncə');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'GAD','Gədəbəy');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'GOR','Goranboy');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'GOY','Göyçay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'HAC','Hacıqabul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'IMI','İmişli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'ISM','İsmayıllı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'KAL','Kəlbəcər');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'KUR','Kürdəmir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'LA','Lənkəran');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'LAC','Laçın');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'LAN','Lənkəran');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'LER','Lerik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'MAS','Masallı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'MI','Mingəçevir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'NA','Naftalan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'NEF','Neftçala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'OGU','Oğuz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'ORD','Ordubad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QAB','Qəbələ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QAX','Qax');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QAZ','Qazax');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QOB','Qobustan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QBA','Quba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QBI','Qubadlı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'QUS','Qusar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SA','Şəki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAT','Saatlı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAB','Sabirabad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAD','Sədərək');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAH','Şahbuz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAK','Şəki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAL','Salyan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SM','Sumqayıt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SMI','Şamaxı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SKR','Şəmkir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SMX','Samux');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SAR','Şərur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SIY','Siyəzən');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SS','Şuşa (City)');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'SUS','Şuşa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'TAR','Tərtər');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'TOV','Tovuz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'UCA','Ucar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'XA','Xankəndi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'XAC','Xaçmaz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'XAN','Xanlar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'XIZ','Xızı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'XCI','Xocalı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'XVD','Xocavənd');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'YAR','Yardımlı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'YE','Yevlax (City)');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'YEV','Yevlax');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'ZAN','Zəngilan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'ZAQ','Zaqatala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'ZAR','Zərdab');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (15,'NX','Nakhichevan');

INSERT INTO kuu_countries VALUES (16,'Bahamas','BS','BHS',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'AC','Acklins and Crooked Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'BI','Bimini');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'CI','Cat Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'EX','Exuma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'FR','Freeport');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'FC','Fresh Creek');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'GH','Governor''s Harbour');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'GT','Green Turtle Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'HI','Harbour Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'HR','High Rock');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'IN','Inagua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'KB','Kemps Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'LI','Long Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'MH','Marsh Harbour');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'MA','Mayaguana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'NP','New Providence');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'NT','Nicholls Town and Berry Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'RI','Ragged Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'RS','Rock Sound');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'SS','San Salvador and Rum Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (16,'SP','Sandy Point');

INSERT INTO kuu_countries VALUES (17,'Bahrain','BH','BHR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'01','الحد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'02','المحرق');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'03','المنامة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'04','جد حفص');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'05','المنطقة الشمالية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'06','سترة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'07','المنطقة الوسطى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'08','مدينة عيسى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'09','الرفاع والمنطقة الجنوبية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'10','المنطقة الغربية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'11','جزر حوار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (17,'12','مدينة حمد');

INSERT INTO kuu_countries VALUES (18,'Bangladesh','BD','BGD',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'01','Bandarban');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'02','Barguna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'03','Bogra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'04','Brahmanbaria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'05','Bagerhat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'06','Barisal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'07','Bhola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'08','Comilla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'09','Chandpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'10','Chittagong');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'11','Cox''s Bazar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'12','Chuadanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'13','Dhaka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'14','Dinajpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'15','Faridpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'16','Feni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'17','Gopalganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'18','Gazipur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'19','Gaibandha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'20','Habiganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'21','Jamalpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'22','Jessore');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'23','Jhenaidah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'24','Jaipurhat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'25','Jhalakati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'26','Kishoreganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'27','Khulna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'28','Kurigram');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'29','Khagrachari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'30','Kushtia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'31','Lakshmipur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'32','Lalmonirhat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'33','Manikganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'34','Mymensingh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'35','Munshiganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'36','Madaripur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'37','Magura');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'38','Moulvibazar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'39','Meherpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'40','Narayanganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'41','Netrakona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'42','Narsingdi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'43','Narail');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'44','Natore');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'45','Nawabganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'46','Nilphamari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'47','Noakhali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'48','Naogaon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'49','Pabna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'50','Pirojpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'51','Patuakhali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'52','Panchagarh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'53','Rajbari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'54','Rajshahi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'55','Rangpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'56','Rangamati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'57','Sherpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'58','Satkhira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'59','Sirajganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'60','Sylhet');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'61','Sunamganj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'62','Shariatpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'63','Tangail');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (18,'64','Thakurgaon');

INSERT INTO kuu_countries VALUES (19,'Barbados','BB','BRB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'A','Saint Andrew');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'C','Christ Church');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'E','Saint Peter');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'G','Saint George');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'J','Saint John');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'L','Saint Lucy');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'M','Saint Michael');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'O','Saint Joseph');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'P','Saint Philip');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'S','Saint James');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (19,'T','Saint Thomas');

INSERT INTO kuu_countries VALUES (20,'Belarus','BY','BLR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (20,'BR','Брэ́сцкая во́бласць');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (20,'HO','Го́мельская во́бласць');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (20,'HR','Гро́дзенская во́бласць');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (20,'MA','Магілёўская во́бласць');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (20,'MI','Мі́нская во́бласць');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (20,'VI','Ві́цебская во́бласць');

INSERT INTO kuu_countries VALUES (21,'Belgium','BE','BEL',E':name\n:street_address\nB-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'BRU','Brussel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'VAN','Antwerpen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'VBR','Vlaams-Brabant');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'VLI','Limburg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'VOV','Oost-Vlaanderen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'VWV','West-Vlaanderen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'WBR','Brabant Wallon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'WHT','Hainaut');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'WLG','Liège/Lüttich');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'WLX','Luxembourg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (21,'WNA','Namur');

INSERT INTO kuu_countries VALUES (22,'Belize','BZ','BLZ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (22,'BZ','Belize District');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (22,'CY','Cayo District');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (22,'CZL','Corozal District');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (22,'OW','Orange Walk District');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (22,'SC','Stann Creek District');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (22,'TOL','Toledo District');

INSERT INTO kuu_countries VALUES (23,'Benin','BJ','BEN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'AL','Alibori');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'AK','Atakora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'AQ','Atlantique');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'BO','Borgou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'CO','Collines');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'DO','Donga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'KO','Kouffo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'LI','Littoral');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'MO','Mono');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'OU','Ouémé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'PL','Plateau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (23,'ZO','Zou');

INSERT INTO kuu_countries VALUES (24,'Bermuda','BM','BMU',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'DEV','Devonshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'HA','Hamilton City');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'HAM','Hamilton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'PAG','Paget');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'PEM','Pembroke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'SAN','Sandys');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'SG','Saint George City');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'SGE','Saint George''s');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'SMI','Smiths');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'SOU','Southampton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (24,'WAR','Warwick');

INSERT INTO kuu_countries VALUES (25,'Bhutan','BT','BTN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'11','Paro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'12','Chukha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'13','Haa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'14','Samtse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'15','Thimphu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'21','Tsirang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'22','Dagana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'23','Punakha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'24','Wangdue Phodrang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'31','Sarpang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'32','Trongsa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'33','Bumthang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'34','Zhemgang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'41','Trashigang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'42','Mongar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'43','Pemagatshel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'44','Luentse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'45','Samdrup Jongkhar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'GA','Gasa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (25,'TY','Trashiyangse');

INSERT INTO kuu_countries VALUES (26,'Bolivia','BO','BOL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'B','El Beni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'C','Cochabamba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'H','Chuquisaca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'L','La Paz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'N','Pando');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'O','Oruro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'P','Potosí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'S','Santa Cruz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (26,'T','Tarija');

INSERT INTO kuu_countries VALUES (27,'Bosnia and Herzegowina','BA','BIH',null);
INSERT INTO kuu_countries VALUES (28,'Botswana','BW','BWA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'CE','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'GH','Ghanzi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'KG','Kgalagadi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'KL','Kgatleng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'KW','Kweneng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'NE','North-East');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'NW','North-West');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'SE','South-East');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (28,'SO','Southern');

INSERT INTO kuu_countries VALUES (29,'Bouvet Island','BV','BVT',null);

INSERT INTO kuu_countries VALUES (30,'Brazil','BR','BRA',E':name\n:street_address\n:state\n:postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'AC','Acre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'AL','Alagoas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'AM','Amazônia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'AP','Amapá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'BA','Bahia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'CE','Ceará');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'DF','Distrito Federal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'ES','Espírito Santo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'GO','Goiás');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'MA','Maranhão');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'MG','Minas Gerais');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'MS','Mato Grosso do Sul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'MT','Mato Grosso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'PA','Pará');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'PB','Paraíba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'PE','Pernambuco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'PI','Piauí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'PR','Paraná');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'RJ','Rio de Janeiro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'RN','Rio Grande do Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'RO','Rondônia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'RR','Roraima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'RS','Rio Grande do Sul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'SC','Santa Catarina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'SE','Sergipe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'SP','São Paulo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (30,'TO','Tocantins');

INSERT INTO kuu_countries VALUES (31,'British Indian Ocean Territory','IO','IOT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'PB','Peros Banhos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'SI','Salomon Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'NI','Nelsons Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'TB','Three Brothers');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'EA','Eagle Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'DI','Danger Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'EG','Egmont Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (31,'DG','Diego Garcia');

INSERT INTO kuu_countries VALUES (32,'Brunei Darussalam','BN','BRN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (32,'BE','Belait');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (32,'BM','Brunei-Muara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (32,'TE','Temburong');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (32,'TU','Tutong');

INSERT INTO kuu_countries VALUES (33,'Bulgaria','BG','BGR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'01','Blagoevgrad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'02','Burgas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'03','Varna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'04','Veliko Tarnovo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'05','Vidin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'06','Vratsa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'07','Gabrovo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'08','Dobrich');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'09','Kardzhali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'10','Kyustendil');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'11','Lovech');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'12','Montana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'13','Pazardzhik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'14','Pernik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'15','Pleven');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'16','Plovdiv');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'17','Razgrad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'18','Ruse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'19','Silistra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'20','Sliven');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'21','Smolyan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'23','Sofia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'22','Sofia Province');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'24','Stara Zagora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'25','Targovishte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'26','Haskovo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'27','Shumen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (33,'28','Yambol');

INSERT INTO kuu_countries VALUES (34,'Burkina Faso','BF','BFA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BAL','Balé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BAM','Bam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BAN','Banwa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BAZ','Bazèga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BGR','Bougouriba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BLG','Boulgou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'BLK','Boulkiemdé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'COM','Komoé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'GAN','Ganzourgou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'GNA','Gnagna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'GOU','Gourma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'HOU','Houet');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'IOB','Ioba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KAD','Kadiogo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KEN','Kénédougou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KMD','Komondjari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KMP','Kompienga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KOP','Koulpélogo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KOS','Kossi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KOT','Kouritenga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'KOW','Kourwéogo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'LER','Léraba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'LOR','Loroum');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'MOU','Mouhoun');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'NAM','Namentenga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'NAO','Naouri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'NAY','Nayala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'NOU','Noumbiel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'OUB','Oubritenga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'OUD','Oudalan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'PAS','Passoré');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'PON','Poni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'SEN','Séno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'SIS','Sissili');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'SMT','Sanmatenga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'SNG','Sanguié');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'SOM','Soum');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'SOR','Sourou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'TAP','Tapoa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'TUI','Tui');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'YAG','Yagha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'YAT','Yatenga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'ZIR','Ziro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'ZON','Zondoma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (34,'ZOU','Zoundwéogo');

INSERT INTO kuu_countries VALUES (35,'Burundi','BI','BDI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'BB','Bubanza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'BJ','Bujumbura Mairie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'BR','Bururi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'CA','Cankuzo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'CI','Cibitoke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'GI','Gitega');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'KR','Karuzi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'KY','Kayanza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'KI','Kirundo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'MA','Makamba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'MU','Muramvya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'MY','Muyinga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'MW','Mwaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'NG','Ngozi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'RT','Rutana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (35,'RY','Ruyigi');

INSERT INTO kuu_countries VALUES (36,'Cambodia','KH','KHM',null);

INSERT INTO kuu_countries VALUES (37,'Cameroon','CM','CMR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'AD','Adamaoua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'CE','Centre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'EN','Extrême-Nord');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'ES','Est');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'LT','Littoral');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'NO','Nord');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'NW','Nord-Ouest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'OU','Ouest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'SU','Sud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (37,'SW','Sud-Ouest');

INSERT INTO kuu_countries VALUES (38,'Canada','CA','CAN',E':name\n:street_address\n:city :state_code :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'AB','Alberta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'BC','British Columbia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'MB','Manitoba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'NB','New Brunswick');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'NL','Newfoundland and Labrador');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'NS','Nova Scotia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'NT','Northwest Territories');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'NU','Nunavut');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'ON','Ontario');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'PE','Prince Edward Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'QC','Quebec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'SK','Saskatchewan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (38,'YT','Yukon Territory');

INSERT INTO kuu_countries VALUES (39,'Cape Verde','CV','CPV',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'BR','Brava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'BV','Boa Vista');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'CA','Santa Catarina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'CR','Santa Cruz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'CS','Calheta de São Miguel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'MA','Maio');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'MO','Mosteiros');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'PA','Paúl');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'PN','Porto Novo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'PR','Praia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'RG','Ribeira Grande');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'SD','São Domingos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'SF','São Filipe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'SL','Sal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'SN','São Nicolau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'SV','São Vicente');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (39,'TA','Tarrafal');

INSERT INTO kuu_countries VALUES (40,'Cayman Islands','KY','CYM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'CR','Creek');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'EA','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'MI','Midland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'SO','South Town');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'SP','Spot Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'ST','Stake Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'WD','West End');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (40,'WN','Western');

INSERT INTO kuu_countries VALUES (41,'Central African Republic','CF','CAF',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'AC ','Ouham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'BB ','Bamingui-Bangoran');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'BGF','Bangui');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'BK ','Basse-Kotto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'HK ','Haute-Kotto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'HM ','Haut-Mbomou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'HS ','Mambéré-Kadéï');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'KB ','Nana-Grébizi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'KG ','Kémo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'LB ','Lobaye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'MB ','Mbomou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'MP ','Ombella-M''Poko');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'NM ','Nana-Mambéré');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'OP ','Ouham-Pendé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'SE ','Sangha-Mbaéré');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'UK ','Ouaka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (41,'VR ','Vakaga');

INSERT INTO kuu_countries VALUES (42,'Chad','TD','TCD',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'BA ','Batha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'BET','Borkou-Ennedi-Tibesti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'BI ','Biltine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'CB ','Chari-Baguirmi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'GR ','Guéra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'KA ','Kanem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'LC ','Lac');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'LR ','Logone-Oriental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'LO ','Logone-Occidental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'MC ','Moyen-Chari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'MK ','Mayo-Kébbi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'OD ','Ouaddaï');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'SA ','Salamat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (42,'TA ','Tandjilé');

INSERT INTO kuu_countries VALUES (43,'Chile','CL','CHL',E':name\n:street_address\n:city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'AI','Aisén del General Carlos Ibañez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'AN','Antofagasta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'AR','La Araucanía');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'AT','Atacama');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'BI','Biobío');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'CO','Coquimbo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'LI','Libertador Bernardo O''Higgins');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'LL','Los Lagos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'MA','Magallanes y de la Antartica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'ML','Maule');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'RM','Metropolitana de Santiago');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'TA','Tarapacá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (43,'VS','Valparaíso');

INSERT INTO kuu_countries VALUES (44,'China','CN','CHN',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'11','北京');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'12','天津');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'13','河北');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'14','山西');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'15','内蒙古自治区');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'21','辽宁');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'22','吉林');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'23','黑龙江省');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'31','上海');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'32','江苏');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'33','浙江');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'34','安徽');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'35','福建');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'36','江西');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'37','山东');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'41','河南');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'42','湖北');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'43','湖南');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'44','广东');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'45','广西壮族自治区');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'46','海南');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'50','重庆');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'51','四川');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'52','贵州');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'53','云南');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'54','西藏自治区');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'61','陕西');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'62','甘肃');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'63','青海');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'64','宁夏');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'65','新疆');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'71','臺灣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'91','香港');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (44,'92','澳門');

INSERT INTO kuu_countries VALUES (45,'Christmas Island','CX','CXR',null);

INSERT INTO kuu_countries VALUES (46,'Cocos (Keeling) Islands','CC','CCK',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (46,'D','Direction Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (46,'H','Home Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (46,'O','Horsburgh Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (46,'S','South Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (46,'W','West Island');

INSERT INTO kuu_countries VALUES (47,'Colombia','CO','COL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'AMA','Amazonas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'ANT','Antioquia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'ARA','Arauca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'ATL','Atlántico');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'BOL','Bolívar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'BOY','Boyacá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CAL','Caldas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CAQ','Caquetá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CAS','Casanare');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CAU','Cauca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CES','Cesar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CHO','Chocó');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'COR','Córdoba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'CUN','Cundinamarca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'DC','Bogotá Distrito Capital');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'GUA','Guainía');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'GUV','Guaviare');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'HUI','Huila');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'LAG','La Guajira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'MAG','Magdalena');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'MET','Meta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'NAR','Nariño');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'NSA','Norte de Santander');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'PUT','Putumayo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'QUI','Quindío');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'RIS','Risaralda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'SAN','Santander');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'SAP','San Andrés y Providencia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'SUC','Sucre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'TOL','Tolima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'VAC','Valle del Cauca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'VAU','Vaupés');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (47,'VID','Vichada');

INSERT INTO kuu_countries VALUES (48,'Comoros','KM','COM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (48,'A','Anjouan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (48,'G','Grande Comore');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (48,'M','Mohéli');

INSERT INTO kuu_countries VALUES (49,'Congo','CG','COG',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'BC','Congo-Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'BN','Bandundu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'EQ','Équateur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'KA','Katanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'KE','Kasai-Oriental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'KN','Kinshasa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'KW','Kasai-Occidental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'MA','Maniema');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'NK','Nord-Kivu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'OR','Orientale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (49,'SK','Sud-Kivu');

INSERT INTO kuu_countries VALUES (50,'Cook Islands','CK','COK',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'PU','Pukapuka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'RK','Rakahanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'MK','Manihiki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'PE','Penrhyn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'NI','Nassau Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'SU','Surwarrow');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'PA','Palmerston');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'AI','Aitutaki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'MA','Manuae');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'TA','Takutea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'MT','Mitiaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'AT','Atiu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'MU','Mauke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'RR','Rarotonga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (50,'MG','Mangaia');

INSERT INTO kuu_countries VALUES (51,'Costa Rica','CR','CRI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'A','Alajuela');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'C','Cartago');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'G','Guanacaste');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'H','Heredia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'L','Limón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'P','Puntarenas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (51,'SJ','San José');

INSERT INTO kuu_countries VALUES (52,'Cote D''Ivoire','CI','CIV',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'01','Lagunes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'02','Haut-Sassandra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'03','Savanes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'04','Vallée du Bandama');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'05','Moyen-Comoé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'06','Dix-Huit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'07','Lacs');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'08','Zanzan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'09','Bas-Sassandra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'10','Denguélé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'11','N''zi-Comoé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'12','Marahoué');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'13','Sud-Comoé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'14','Worodouqou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'15','Sud-Bandama');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'16','Agnébi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'17','Bafing');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'18','Fromager');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (52,'19','Moyen-Cavally');

INSERT INTO kuu_countries VALUES (53,'Croatia','HR','HRV',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'01','Zagrebačka županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'02','Krapinsko-zagorska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'03','Sisačko-moslavačka županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'04','Karlovačka županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'05','Varaždinska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'06','Koprivničko-križevačka županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'07','Bjelovarsko-bilogorska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'08','Primorsko-goranska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'09','Ličko-senjska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'10','Virovitičko-podravska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'11','Požeško-slavonska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'12','Brodsko-posavska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'13','Zadarska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'14','Osječko-baranjska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'15','Šibensko-kninska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'16','Vukovarsko-srijemska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'17','Splitsko-dalmatinska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'18','Istarska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'19','Dubrovačko-neretvanska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'20','Međimurska županija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (53,'21','Zagreb');

INSERT INTO kuu_countries VALUES (54,'Cuba','CU','CUB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'01','Pinar del Río');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'02','La Habana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'03','Ciudad de La Habana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'04','Matanzas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'05','Villa Clara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'06','Cienfuegos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'07','Sancti Spíritus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'08','Ciego de Ávila');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'09','Camagüey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'10','Las Tunas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'11','Holguín');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'12','Granma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'13','Santiago de Cuba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'14','Guantánamo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (54,'99','Isla de la Juventud');

INSERT INTO kuu_countries VALUES (55,'Cyprus','CY','CYP',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (55,'01','Κερύvεια');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (55,'02','Λευκωσία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (55,'03','Αμμόχωστος');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (55,'04','Λάρνακα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (55,'05','Λεμεσός');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (55,'06','Πάφος');

INSERT INTO kuu_countries VALUES (56,'Czech Republic','CZ','CZE',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'JC','Jihočeský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'JM','Jihomoravský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'KA','Karlovarský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'VY','Vysočina kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'KR','Královéhradecký kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'LI','Liberecký kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'MO','Moravskoslezský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'OL','Olomoucký kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'PA','Pardubický kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'PL','Plzeňský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'PR','Hlavní město Praha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'ST','Středočeský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'US','Ústecký kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (56,'ZL','Zlínský kraj');

INSERT INTO kuu_countries VALUES (57,'Denmark','DK','DNK',E':name\n:street_address\nDK-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'040','Bornholms Regionskommune');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'101','København');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'147','Frederiksberg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'070','Århus Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'015','Københavns Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'020','Frederiksborg Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'042','Fyns Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'080','Nordjyllands Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'055','Ribe Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'065','Ringkjøbing Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'025','Roskilde Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'050','Sønderjyllands Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'035','Storstrøms Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'060','Vejle Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'030','Vestsjællands Amt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (57,'076','Viborg Amt');

INSERT INTO kuu_countries VALUES (58,'Djibouti','DJ','DJI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (58,'AS','Region d''Ali Sabieh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (58,'AR','Region d''Arta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (58,'DI','Region de Dikhil');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (58,'DJ','Ville de Djibouti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (58,'OB','Region d''Obock');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (58,'TA','Region de Tadjourah');

INSERT INTO kuu_countries VALUES (59,'Dominica','DM','DMA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'AND','Saint Andrew Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'DAV','Saint David Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'GEO','Saint George Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'JOH','Saint John Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'JOS','Saint Joseph Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'LUK','Saint Luke Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'MAR','Saint Mark Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'PAT','Saint Patrick Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'PAU','Saint Paul Parish');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (59,'PET','Saint Peter Parish');

INSERT INTO kuu_countries VALUES (60,'Dominican Republic','DO','DOM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'01','Distrito Nacional');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'02','Ázua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'03','Baoruco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'04','Barahona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'05','Dajabón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'06','Duarte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'07','Elías Piña');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'08','El Seibo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'09','Espaillat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'10','Independencia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'11','La Altagracia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'12','La Romana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'13','La Vega');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'14','María Trinidad Sánchez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'15','Monte Cristi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'16','Pedernales');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'17','Peravia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'18','Puerto Plata');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'19','Salcedo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'20','Samaná');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'21','San Cristóbal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'22','San Juan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'23','San Pedro de Macorís');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'24','Sánchez Ramírez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'25','Santiago');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'26','Santiago Rodríguez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'27','Valverde');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'28','Monseñor Nouel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'29','Monte Plata');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (60,'30','Hato Mayor');

INSERT INTO kuu_countries VALUES (61,'East Timor','TP','TMP',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'AL','Aileu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'AN','Ainaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'BA','Baucau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'BO','Bobonaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'CO','Cova-Lima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'DI','Dili');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'ER','Ermera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'LA','Lautem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'LI','Liquiçá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'MF','Manufahi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'MT','Manatuto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'OE','Oecussi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (61,'VI','Viqueque');

INSERT INTO kuu_countries VALUES (62,'Ecuador','EC','ECU',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'A','Azuay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'B','Bolívar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'C','Carchi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'D','Orellana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'E','Esmeraldas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'F','Cañar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'G','Guayas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'H','Chimborazo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'I','Imbabura');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'L','Loja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'M','Manabí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'N','Napo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'O','El Oro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'P','Pichincha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'R','Los Ríos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'S','Morona-Santiago');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'T','Tungurahua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'U','Sucumbíos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'W','Galápagos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'X','Cotopaxi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'Y','Pastaza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (62,'Z','Zamora-Chinchipe');

INSERT INTO kuu_countries VALUES (63,'Egypt','EG','EGY',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'ALX','الإسكندرية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'ASN','أسوان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'AST','أسيوط');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'BA','البحر الأحمر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'BH','البحيرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'BNS','بني سويف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'C','القاهرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'DK','الدقهلية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'DT','دمياط');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'FYM','الفيوم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'GH','الغربية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'GZ','الجيزة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'IS','الإسماعيلية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'JS','جنوب سيناء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'KB','القليوبية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'KFS','كفر الشيخ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'KN','قنا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'MN','محافظة المنيا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'MNF','المنوفية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'MT','مطروح');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'PTS','محافظة بور سعيد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'SHG','محافظة سوهاج');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'SHR','المحافظة الشرقيّة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'SIN','شمال سيناء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'SUZ','السويس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (63,'WAD','الوادى الجديد');

INSERT INTO kuu_countries VALUES (64,'El Salvador','SV','SLV',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'AH','Ahuachapán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'CA','Cabañas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'CH','Chalatenango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'CU','Cuscatlán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'LI','La Libertad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'MO','Morazán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'PA','La Paz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'SA','Santa Ana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'SM','San Miguel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'SO','Sonsonate');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'SS','San Salvador');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'SV','San Vicente');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'UN','La Unión');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (64,'US','Usulután');

INSERT INTO kuu_countries VALUES (65,'Equatorial Guinea','GQ','GNQ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'AN','Annobón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'BN','Bioko Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'BS','Bioko Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'CS','Centro Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'KN','Kié-Ntem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'LI','Litoral');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (65,'WN','Wele-Nzas');

INSERT INTO kuu_countries VALUES (66,'Eritrea','ER','ERI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (66,'AN','Zoba Anseba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (66,'DK','Zoba Debubawi Keyih Bahri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (66,'DU','Zoba Debub');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (66,'GB','Zoba Gash-Barka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (66,'MA','Zoba Ma''akel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (66,'SK','Zoba Semienawi Keyih Bahri');

INSERT INTO kuu_countries VALUES (67,'Estonia','EE','EST',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'37','Harju maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'39','Hiiu maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'44','Ida-Viru maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'49','Jõgeva maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'51','Järva maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'57','Lääne maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'59','Lääne-Viru maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'65','Põlva maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'67','Pärnu maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'70','Rapla maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'74','Saare maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'78','Tartu maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'82','Valga maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'84','Viljandi maakond');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (67,'86','Võru maakond');

INSERT INTO kuu_countries VALUES (68,'Ethiopia','ET','ETH',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'AA','አዲስ አበባ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'AF','አፋር');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'AH','አማራ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'BG','ቤንሻንጉል-ጉምዝ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'DD','ድሬዳዋ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'GB','ጋምቤላ ሕዝቦች');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'HR','ሀረሪ ሕዝብ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'OR','ኦሮሚያ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'SM','ሶማሌ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'SN','ደቡብ ብሔሮች ብሔረሰቦችና ሕዝቦች');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (68,'TG','ትግራይ');

INSERT INTO kuu_countries VALUES (69,'Falkland Islands (Malvinas)','FK','FLK',null);
INSERT INTO kuu_countries VALUES (70,'Faroe Islands','FO','FRO',null);

INSERT INTO kuu_countries VALUES (71,'Fiji','FJ','FJI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (71,'C','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (71,'E','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (71,'N','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (71,'R','Rotuma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (71,'W','Western');

INSERT INTO kuu_countries VALUES (72,'Finland','FI','FIN',E':name\n:street_address\nFIN-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (72,'AL','Ahvenanmaan maakunta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (72,'ES','Etelä-Suomen lääni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (72,'IS','Itä-Suomen lääni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (72,'LL','Lapin lääni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (72,'LS','Länsi-Suomen lääni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (72,'OL','Oulun lääni');

INSERT INTO kuu_countries VALUES (73,'France','FR','FRA',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'01','Ain');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'02','Aisne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'03','Allier');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'04','Alpes-de-Haute-Provence');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'05','Hautes-Alpes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'06','Alpes-Maritimes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'07','Ardèche');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'08','Ardennes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'09','Ariège');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'10','Aube');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'11','Aude');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'12','Aveyron');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'13','Bouches-du-Rhône');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'14','Calvados');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'15','Cantal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'16','Charente');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'17','Charente-Maritime');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'18','Cher');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'19','Corrèze');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'21','Côte-d''Or');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'22','Côtes-d''Armor');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'23','Creuse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'24','Dordogne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'25','Doubs');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'26','Drôme');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'27','Eure');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'28','Eure-et-Loir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'29','Finistère');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'2A','Corse-du-Sud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'2B','Haute-Corse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'30','Gard');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'31','Haute-Garonne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'32','Gers');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'33','Gironde');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'34','Hérault');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'35','Ille-et-Vilaine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'36','Indre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'37','Indre-et-Loire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'38','Isère');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'39','Jura');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'40','Landes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'41','Loir-et-Cher');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'42','Loire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'43','Haute-Loire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'44','Loire-Atlantique');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'45','Loiret');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'46','Lot');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'47','Lot-et-Garonne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'48','Lozère');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'49','Maine-et-Loire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'50','Manche');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'51','Marne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'52','Haute-Marne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'53','Mayenne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'54','Meurthe-et-Moselle');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'55','Meuse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'56','Morbihan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'57','Moselle');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'58','Nièvre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'59','Nord');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'60','Oise');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'61','Orne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'62','Pas-de-Calais');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'63','Puy-de-Dôme');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'64','Pyrénées-Atlantiques');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'65','Hautes-Pyrénées');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'66','Pyrénées-Orientales');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'67','Bas-Rhin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'68','Haut-Rhin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'69','Rhône');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'70','Haute-Saône');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'71','Saône-et-Loire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'72','Sarthe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'73','Savoie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'74','Haute-Savoie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'75','Paris');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'76','Seine-Maritime');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'77','Seine-et-Marne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'78','Yvelines');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'79','Deux-Sèvres');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'80','Somme');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'81','Tarn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'82','Tarn-et-Garonne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'83','Var');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'84','Vaucluse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'85','Vendée');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'86','Vienne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'87','Haute-Vienne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'88','Vosges');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'89','Yonne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'90','Territoire de Belfort');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'91','Essonne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'92','Hauts-de-Seine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'93','Seine-Saint-Denis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'94','Val-de-Marne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'95','Val-d''Oise');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'NC','Territoire des Nouvelle-Calédonie et Dependances');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'PF','Polynésie Française');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'PM','Saint-Pierre et Miquelon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'TF','Terres australes et antarctiques françaises');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'YT','Mayotte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (73,'WF','Territoire des îles Wallis et Futuna');

INSERT INTO kuu_countries VALUES (74,'France, Metropolitan','FX','FXX',E':name\n:street_address\n:postcode :city\n:country');
INSERT INTO kuu_countries VALUES (75,'French Guiana','GF','GUF',E':name\n:street_address\n:postcode :city\n:country');
INSERT INTO kuu_countries VALUES (76,'French Polynesia','PF','PYF',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (76,'M','Archipel des Marquises');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (76,'T','Archipel des Tuamotu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (76,'I','Archipel des Tubuai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (76,'V','Iles du Vent');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (76,'S','Iles Sous-le-Vent ');

INSERT INTO kuu_countries VALUES (77,'French Southern Territories','TF','ATF',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (77,'C','Iles Crozet');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (77,'K','Iles Kerguelen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (77,'A','Ile Amsterdam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (77,'P','Ile Saint-Paul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (77,'D','Adelie Land');

INSERT INTO kuu_countries VALUES (78,'Gabon','GA','GAB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'ES','Estuaire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'HO','Haut-Ogooue');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'MO','Moyen-Ogooue');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'NG','Ngounie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'NY','Nyanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'OI','Ogooue-Ivindo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'OL','Ogooue-Lolo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'OM','Ogooue-Maritime');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (78,'WN','Woleu-Ntem');

INSERT INTO kuu_countries VALUES (79,'Gambia','GM','GMB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'AH','Ashanti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'BA','Brong-Ahafo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'CP','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'EP','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'AA','Greater Accra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'NP','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'UE','Upper East');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'UW','Upper West');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'TV','Volta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (79,'WP','Western');

INSERT INTO kuu_countries VALUES (80,'Georgia','GE','GEO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'AB','აფხაზეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'AJ','აჭარა');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'GU','გურია');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'IM','იმერეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'KA','კახეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'KK','ქვემო ქართლი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'MM','მცხეთა-მთიანეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'RL','რაჭა-ლეჩხუმი და ქვემო სვანეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'SJ','სამცხე-ჯავახეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'SK','შიდა ქართლი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'SZ','სამეგრელო-ზემო სვანეთი');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (80,'TB','თბილისი');

INSERT INTO kuu_countries VALUES (81,'Germany','DE','DEU',E':name\n:street_address\nD-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'BE','Berlin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'BR','Brandenburg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'BW','Baden-Württemberg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'BY','Bayern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'HB','Bremen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'HE','Hessen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'HH','Hamburg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'MV','Mecklenburg-Vorpommern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'NI','Niedersachsen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'NW','Nordrhein-Westfalen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'RP','Rheinland-Pfalz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'SH','Schleswig-Holstein');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'SL','Saarland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'SN','Sachsen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'ST','Sachsen-Anhalt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (81,'TH','Thüringen');

INSERT INTO kuu_countries VALUES (82,'Ghana','GH','GHA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'AA','Greater Accra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'AH','Ashanti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'BA','Brong-Ahafo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'CP','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'EP','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'NP','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'TV','Volta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'UE','Upper East');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'UW','Upper West');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (82,'WP','Western');

INSERT INTO kuu_countries VALUES (83,'Gibraltar','GI','GIB',null);

INSERT INTO kuu_countries VALUES (84,'Greece','GR','GRC',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'01','Αιτωλοακαρνανία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'03','Βοιωτία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'04','Εύβοια');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'05','Ευρυτανία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'06','Φθιώτιδα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'07','Φωκίδα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'11','Αργολίδα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'12','Αρκαδία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'13','Ἀχαΐα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'14','Ηλεία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'15','Κορινθία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'16','Λακωνία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'17','Μεσσηνία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'21','Ζάκυνθος');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'22','Κέρκυρα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'23','Κεφαλλονιά');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'24','Λευκάδα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'31','Άρτα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'32','Θεσπρωτία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'33','Ιωάννινα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'34','Πρεβεζα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'41','Καρδίτσα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'42','Λάρισα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'43','Μαγνησία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'44','Τρίκαλα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'51','Γρεβενά');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'52','Δράμα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'53','Ημαθία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'54','Θεσσαλονίκη');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'55','Καβάλα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'56','Καστοριά');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'57','Κιλκίς');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'58','Κοζάνη');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'59','Πέλλα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'61','Πιερία');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'62','Σερρών');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'63','Φλώρινα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'64','Χαλκιδική');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'69','Όρος Άθως');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'71','Έβρος');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'72','Ξάνθη');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'73','Ροδόπη');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'81','Δωδεκάνησα');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'82','Κυκλάδες');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'83','Λέσβου');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'84','Σάμος');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'85','Χίος');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'91','Ηράκλειο');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'92','Λασίθι');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'93','Ρεθύμνο');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'94','Χανίων');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (84,'A1','Αττική');

INSERT INTO kuu_countries VALUES (85,'Greenland','GL','GRL',E':name\n:street_address\nDK-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (85,'A','Avannaa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (85,'T','Tunu ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (85,'K','Kitaa');

INSERT INTO kuu_countries VALUES (86,'Grenada','GD','GRD',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (86,'A','Saint Andrew');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (86,'D','Saint David');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (86,'G','Saint George');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (86,'J','Saint John');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (86,'M','Saint Mark');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (86,'P','Saint Patrick');

INSERT INTO kuu_countries VALUES (87,'Guadeloupe','GP','GLP',null);
INSERT INTO kuu_countries VALUES (88,'Guam','GU','GUM',null);

INSERT INTO kuu_countries VALUES (89,'Guatemala','GT','GTM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'AV','Alta Verapaz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'BV','Baja Verapaz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'CM','Chimaltenango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'CQ','Chiquimula');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'ES','Escuintla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'GU','Guatemala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'HU','Huehuetenango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'IZ','Izabal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'JA','Jalapa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'JU','Jutiapa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'PE','El Petén');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'PR','El Progreso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'QC','El Quiché');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'QZ','Quetzaltenango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'RE','Retalhuleu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'SA','Sacatepéquez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'SM','San Marcos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'SO','Sololá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'SR','Santa Rosa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'SU','Suchitepéquez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'TO','Totonicapán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (89,'ZA','Zacapa');

INSERT INTO kuu_countries VALUES (90,'Guinea','GN','GIN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'BE','Beyla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'BF','Boffa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'BK','Boké');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'CO','Coyah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'DB','Dabola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'DI','Dinguiraye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'DL','Dalaba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'DU','Dubréka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'FA','Faranah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'FO','Forécariah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'FR','Fria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'GA','Gaoual');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'GU','Guékédou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KA','Kankan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KB','Koubia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KD','Kindia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KE','Kérouané');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KN','Koundara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KO','Kouroussa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'KS','Kissidougou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'LA','Labé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'LE','Lélouma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'LO','Lola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'MC','Macenta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'MD','Mandiana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'ML','Mali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'MM','Mamou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'NZ','Nzérékoré');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'PI','Pita');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'SI','Siguiri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'TE','Télimélé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'TO','Tougué');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (90,'YO','Yomou');

INSERT INTO kuu_countries VALUES (91,'Guinea-Bissau','GW','GNB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'BF','Bafata');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'BB','Biombo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'BS','Bissau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'BL','Bolama');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'CA','Cacheu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'GA','Gabu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'OI','Oio');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'QU','Quinara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (91,'TO','Tombali');

INSERT INTO kuu_countries VALUES (92,'Guyana','GY','GUY',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'BA','Barima-Waini');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'CU','Cuyuni-Mazaruni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'DE','Demerara-Mahaica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'EB','East Berbice-Corentyne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'ES','Essequibo Islands-West Demerara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'MA','Mahaica-Berbice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'PM','Pomeroon-Supenaam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'PT','Potaro-Siparuni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'UD','Upper Demerara-Berbice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (92,'UT','Upper Takutu-Upper Essequibo');

INSERT INTO kuu_countries VALUES (93,'Haiti','HT','HTI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'AR','Artibonite');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'CE','Centre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'GA','Grand''Anse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'NI','Nippes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'ND','Nord');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'NE','Nord-Est');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'NO','Nord-Ouest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'OU','Ouest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'SD','Sud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (93,'SE','Sud-Est');

INSERT INTO kuu_countries VALUES (94,'Heard and McDonald Islands','HM','HMD',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (94,'F','Flat Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (94,'M','McDonald Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (94,'S','Shag Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (94,'H','Heard Island');

INSERT INTO kuu_countries VALUES (95,'Honduras','HN','HND',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'AT','Atlántida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'CH','Choluteca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'CL','Colón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'CM','Comayagua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'CP','Copán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'CR','Cortés');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'EP','El Paraíso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'FM','Francisco Morazán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'GD','Gracias a Dios');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'IB','Islas de la Bahía');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'IN','Intibucá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'LE','Lempira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'LP','La Paz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'OC','Ocotepeque');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'OL','Olancho');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'SB','Santa Bárbara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'VA','Valle');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (95,'YO','Yoro');

INSERT INTO kuu_countries VALUES (96,'Hong Kong','HK','HKG',E':name\n:street_address\n:city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'HCW','中西區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'HEA','東區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'HSO','南區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'HWC','灣仔區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'KKC','九龍城區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'KKT','觀塘區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'KSS','深水埗區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'KWT','黃大仙區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'KYT','油尖旺區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NIS','離島區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NKT','葵青區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NNO','北區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NSK','西貢區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NST','沙田區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NTP','大埔區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NTW','荃灣區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NTM','屯門區');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (96,'NYL','元朗區');

INSERT INTO kuu_countries VALUES (97,'Hungary','HU','HUN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'BA','Baranya megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'BC','Békéscsaba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'BE','Békés megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'BK','Bács-Kiskun megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'BU','Budapest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'BZ','Borsod-Abaúj-Zemplén megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'CS','Csongrád megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'DE','Debrecen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'DU','Dunaújváros');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'EG','Eger');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'FE','Fejér megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'GS','Győr-Moson-Sopron megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'GY','Győr');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'HB','Hajdú-Bihar megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'HE','Heves megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'HV','Hódmezővásárhely');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'JN','Jász-Nagykun-Szolnok megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'KE','Komárom-Esztergom megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'KM','Kecskemét');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'KV','Kaposvár');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'MI','Miskolc');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'NK','Nagykanizsa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'NO','Nógrád megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'NY','Nyíregyháza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'PE','Pest megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'PS','Pécs');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SD','Szeged');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SF','Székesfehérvár');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SH','Szombathely');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SK','Szolnok');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SN','Sopron');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SO','Somogy megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SS','Szekszárd');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'ST','Salgótarján');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'SZ','Szabolcs-Szatmár-Bereg megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'TB','Tatabánya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'TO','Tolna megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'VA','Vas megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'VE','Veszprém megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'VM','Veszprém');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'ZA','Zala megye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (97,'ZE','Zalaegerszeg');

INSERT INTO kuu_countries VALUES (98,'Iceland','IS','ISL',E':name\n:street_address\nIS:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'1','Höfuðborgarsvæðið');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'2','Suðurnes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'3','Vesturland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'4','Vestfirðir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'5','Norðurland vestra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'6','Norðurland eystra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'7','Austfirðir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (98,'8','Suðurland');

INSERT INTO kuu_countries VALUES (99,'India','IN','IND',E':name\n:street_address\n:city-:postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-AN','अंडमान और निकोबार द्वीप');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-AP','ఆంధ్ర ప్రదేశ్');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-AR','अरुणाचल प्रदेश');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-AS','অসম');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-BR','बिहार');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-CH','चंडीगढ़');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-CT','छत्तीसगढ़');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-DD','દમણ અને દિવ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-DL','दिल्ली');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-DN','દાદરા અને નગર હવેલી');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-GA','गोंय');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-GJ','ગુજરાત');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-HP','हिमाचल प्रदेश');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-HR','हरियाणा');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-JH','झारखंड');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-JK','जम्मू और कश्मीर');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-KA','ಕನಾ೯ಟಕ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-KL','കേരളം');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-LD','ലക്ഷദ്വീപ്');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-ML','मेघालय');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-MH','महाराष्ट्र');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-MN','मणिपुर');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-MP','मध्य प्रदेश');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-MZ','मिज़ोरम');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-NL','नागालैंड');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-OR','उड़ीसा');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-PB','ਪੰਜਾਬ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-PY','புதுச்சேரி');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-RJ','राजस्थान');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-SK','सिक्किम');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-TN','தமிழ் நாடு');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-TR','ত্রিপুরা');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-UL','उत्तरांचल');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-UP','उत्तर प्रदेश');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (99,'IN-WB','পশ্চিমবঙ্গ');

INSERT INTO kuu_countries VALUES (100,'Indonesia','ID','IDN',E':name\n:street_address\n:city :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'AC','Aceh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'BA','Bali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'BB','Bangka-Belitung');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'BE','Bengkulu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'BT','Banten');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'GO','Gorontalo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'IJ','Papua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'JA','Jambi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'JI','Jawa Timur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'JK','Jakarta Raya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'JR','Jawa Barat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'JT','Jawa Tengah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'KB','Kalimantan Barat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'KI','Kalimantan Timur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'KS','Kalimantan Selatan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'KT','Kalimantan Tengah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'LA','Lampung');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'MA','Maluku');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'MU','Maluku Utara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'NB','Nusa Tenggara Barat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'NT','Nusa Tenggara Timur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'RI','Riau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'SB','Sumatera Barat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'SG','Sulawesi Tenggara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'SL','Sumatera Selatan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'SN','Sulawesi Selatan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'ST','Sulawesi Tengah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'SW','Sulawesi Utara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'SU','Sumatera Utara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (100,'YO','Yogyakarta');

INSERT INTO kuu_countries VALUES (101,'Iran','IR','IRN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'01','محافظة آذربایجان شرقي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'02','محافظة آذربایجان غربي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'03','محافظة اردبیل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'04','محافظة اصفهان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'05','محافظة ایلام');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'06','محافظة بوشهر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'07','محافظة طهران');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'08','محافظة چهارمحل و بختیاري');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'09','محافظة خراسان رضوي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'10','محافظة خوزستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'11','محافظة زنجان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'12','محافظة سمنان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'13','محافظة سيستان وبلوتشستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'14','محافظة فارس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'15','محافظة کرمان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'16','محافظة کردستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'17','محافظة کرمانشاه');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'18','محافظة کهکیلویه و بویر أحمد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'19','محافظة گیلان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'20','محافظة لرستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'21','محافظة مازندران');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'22','محافظة مرکزي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'23','محافظة هرمزگان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'24','محافظة همدان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'25','محافظة یزد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'26','محافظة قم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'27','محافظة گلستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (101,'28','محافظة قزوين');

INSERT INTO kuu_countries VALUES (102,'Iraq','IQ','IRQ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'AN','محافظة الأنبار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'AR','أربيل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'BA','محافظة البصرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'BB','بابل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'BG','محافظة بغداد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'DA','دهوك');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'DI','ديالى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'DQ','ذي قار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'KA','كربلاء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'MA','ميسان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'MU','المثنى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'NA','النجف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'NI','نینوى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'QA','القادسية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'SD','صلاح الدين');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'SW','محافظة السليمانية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'TS','التأمیم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (102,'WA','واسط');

INSERT INTO kuu_countries VALUES (103,'Ireland','IE','IRL',E':name\n:street_address\nIE-:city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'C','Corcaigh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'CE','Contae an Chláir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'CN','An Cabhán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'CW','Ceatharlach');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'D','Baile Átha Cliath');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'DL','Dún na nGall');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'G','Gaillimh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'KE','Cill Dara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'KK','Cill Chainnigh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'KY','Contae Chiarraí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'LD','An Longfort');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'LH','Contae Lú');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'LK','Luimneach');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'LM','Contae Liatroma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'LS','Contae Laoise');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'MH','Contae na Mí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'MN','Muineachán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'MO','Contae Mhaigh Eo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'OY','Contae Uíbh Fhailí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'RN','Ros Comáin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'SO','Sligeach');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'TA','Tiobraid Árann');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'WD','Port Lairge');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'WH','Contae na hIarmhí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'WW','Cill Mhantáin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (103,'WX','Loch Garman');

INSERT INTO kuu_countries VALUES (104,'Israel','IL','ISR',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (104,'D ','מחוז הדרום');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (104,'HA','מחוז חיפה');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (104,'JM','ירושלים');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (104,'M ','מחוז המרכז');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (104,'TA','תל אביב-יפו');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (104,'Z ','מחוז הצפון');

INSERT INTO kuu_countries VALUES (105,'Italy','IT','ITA',E':name\n:street_address\n:postcode-:city :state_code\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AG','Agrigento');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AL','Alessandria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AN','Ancona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AO','Valle d''Aosta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AP','Ascoli Piceno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AQ','L''Aquila');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AR','Arezzo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AT','Asti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'AV','Avellino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BA','Bari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BG','Bergamo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BI','Biella');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BL','Belluno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BN','Benevento');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BO','Bologna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BR','Brindisi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BS','Brescia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BT','Barletta-Andria-Trani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'BZ','Alto Adige');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CA','Cagliari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CB','Campobasso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CE','Caserta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CH','Chieti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CI','Carbonia-Iglesias');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CL','Caltanissetta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CN','Cuneo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CO','Como');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CR','Cremona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CS','Cosenza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CT','Catania');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'CZ','Catanzaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'EN','Enna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'FE','Ferrara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'FG','Foggia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'FI','Firenze');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'FM','Fermo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'FO','Forlì-Cesena');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'FR','Frosinone');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'GE','Genova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'GO','Gorizia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'GR','Grosseto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'IM','Imperia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'IS','Isernia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'KR','Crotone');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'LC','Lecco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'LE','Lecce');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'LI','Livorno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'LO','Lodi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'LT','Latina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'LU','Lucca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MC','Macerata');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MD','Medio Campidano');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'ME','Messina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MI','Milano');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MN','Mantova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MO','Modena');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MS','Massa-Carrara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MT','Matera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'MZ','Monza e Brianza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'NA','Napoli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'NO','Novara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'NU','Nuoro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'OG','Ogliastra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'OR','Oristano');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'OT','Olbia-Tempio');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PA','Palermo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PC','Piacenza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PD','Padova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PE','Pescara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PG','Perugia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PI','Pisa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PN','Pordenone');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PO','Prato');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PR','Parma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PS','Pesaro e Urbino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PT','Pistoia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PV','Pavia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'PZ','Potenza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RA','Ravenna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RC','Reggio Calabria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RE','Reggio Emilia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RG','Ragusa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RI','Rieti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RM','Roma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RN','Rimini');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'RO','Rovigo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SA','Salerno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SI','Siena');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SO','Sondrio');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SP','La Spezia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SR','Siracusa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SS','Sassari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'SV','Savona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TA','Taranto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TE','Teramo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TN','Trento');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TO','Torino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TP','Trapani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TR','Terni');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TS','Trieste');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'TV','Treviso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'UD','Udine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VA','Varese');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VB','Verbano-Cusio-Ossola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VC','Vercelli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VE','Venezia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VI','Vicenza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VR','Verona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VT','Viterbo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (105,'VV','Vibo Valentia');

INSERT INTO kuu_countries VALUES (106,'Jamaica','JM','JAM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'01','Kingston');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'02','Half Way Tree');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'03','Morant Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'04','Port Antonio');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'05','Port Maria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'06','Saint Ann''s Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'07','Falmouth');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'08','Montego Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'09','Lucea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'10','Savanna-la-Mar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'11','Black River');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'12','Mandeville');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'13','May Pen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (106,'14','Spanish Town');

INSERT INTO kuu_countries VALUES (107,'Japan','JP','JPN',E':name\n:street_address, :suburb\n:city :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'01','北海道');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'02','青森');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'03','岩手');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'04','宮城');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'05','秋田');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'06','山形');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'07','福島');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'08','茨城');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'09','栃木');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'10','群馬');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'11','埼玉');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'12','千葉');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'13','東京');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'14','神奈川');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'15','新潟');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'16','富山');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'17','石川');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'18','福井');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'19','山梨');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'20','長野');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'21','岐阜');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'22','静岡');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'23','愛知');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'24','三重');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'25','滋賀');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'26','京都');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'27','大阪');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'28','兵庫');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'29','奈良');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'30','和歌山');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'31','鳥取');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'32','島根');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'33','岡山');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'34','広島');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'35','山口');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'36','徳島');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'37','香川');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'38','愛媛');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'39','高知');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'40','福岡');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'41','佐賀');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'42','長崎');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'43','熊本');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'44','大分');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'45','宮崎');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'46','鹿児島');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (107,'47','沖縄');

INSERT INTO kuu_countries VALUES (108,'Jordan','JO','JOR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'AJ','محافظة عجلون');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'AM','محافظة العاصمة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'AQ','محافظة العقبة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'AT','محافظة الطفيلة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'AZ','محافظة الزرقاء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'BA','محافظة البلقاء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'JA','محافظة جرش');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'JR','محافظة إربد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'KA','محافظة الكرك');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'MA','محافظة المفرق');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'MD','محافظة مادبا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (108,'MN','محافظة معان');

INSERT INTO kuu_countries VALUES (109,'Kazakhstan','KZ','KAZ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'AL','Алматы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'AC','Almaty City');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'AM','Ақмола');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'AQ','Ақтөбе');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'AS','Астана');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'AT','Атырау');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'BA','Батыс Қазақстан');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'BY','Байқоңыр');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'MA','Маңғыстау');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'ON','Оңтүстік Қазақстан');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'PA','Павлодар');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'QA','Қарағанды');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'QO','Қостанай');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'QY','Қызылорда');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'SH','Шығыс Қазақстан');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'SO','Солтүстік Қазақстан');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (109,'ZH','Жамбыл');

INSERT INTO kuu_countries VALUES (110,'Kenya','KE','KEN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'110','Nairobi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'200','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'300','Mombasa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'400','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'500','North Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'600','Nyanza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'700','Rift Valley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (110,'900','Western');

INSERT INTO kuu_countries VALUES (111,'Kiribati','KI','KIR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (111,'G','Gilbert Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (111,'L','Line Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (111,'P','Phoenix Islands');

INSERT INTO kuu_countries VALUES (112,'Korea, North','KP','PRK',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'CHA','자강도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'HAB','함경 북도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'HAN','함경 남도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'HWB','황해 북도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'HWN','황해 남도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'KAN','강원도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'KAE','개성시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'NAJ','라선 직할시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'NAM','남포 특급시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'PYB','평안 북도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'PYN','평안 남도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'PYO','평양 직할시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (112,'YAN','량강도');

INSERT INTO kuu_countries VALUES (113,'Korea, South','KR','KOR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'11','서울특별시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'26','부산 광역시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'27','대구 광역시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'28','인천광역시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'29','광주 광역시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'30','대전 광역시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'31','울산 광역시');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'41','경기도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'42','강원도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'43','충청 북도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'44','충청 남도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'45','전라 북도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'46','전라 남도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'47','경상 북도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'48','경상 남도');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (113,'49','제주특별자치도');

INSERT INTO kuu_countries VALUES (114,'Kuwait','KW','KWT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (114,'AH','الاحمدي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (114,'FA','الفروانية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (114,'JA','الجهراء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (114,'KU','ألعاصمه');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (114,'HW','حولي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (114,'MU','مبارك الكبير');

INSERT INTO kuu_countries VALUES (115,'Kyrgyzstan','KG','KGZ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'B','Баткен областы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'C','Чүй областы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'GB','Бишкек');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'J','Жалал-Абад областы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'N','Нарын областы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'O','Ош областы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'T','Талас областы');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (115,'Y','Ысык-Көл областы');

INSERT INTO kuu_countries VALUES (116,'Laos','LA','LAO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'AT','ອັດຕະປື');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'BK','ບໍ່ແກ້ວ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'BL','ບໍລິຄໍາໄຊ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'CH','ຈໍາປາສັກ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'HO','ຫົວພັນ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'KH','ຄໍາມ່ວນ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'LM','ຫລວງນໍ້າທາ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'LP','ຫລວງພະບາງ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'OU','ອຸດົມໄຊ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'PH','ຜົງສາລີ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'SL','ສາລະວັນ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'SV','ສະຫວັນນະເຂດ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'VI','ວຽງຈັນ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'VT','ວຽງຈັນ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'XA','ໄຊຍະບູລີ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'XE','ເຊກອງ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'XI','ຊຽງຂວາງ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (116,'XN','ໄຊສົມບູນ');

INSERT INTO kuu_countries VALUES (117,'Latvia','LV','LVA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'AI','Aizkraukles rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'AL','Alūksnes rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'BL','Balvu rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'BU','Bauskas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'CE','Cēsu rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'DA','Daugavpils rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'DGV','Daugpilis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'DO','Dobeles rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'GU','Gulbenes rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'JEL','Jelgava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'JK','Jēkabpils rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'JL','Jelgavas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'JUR','Jūrmala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'KR','Krāslavas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'KU','Kuldīgas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'LE','Liepājas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'LM','Limbažu rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'LPX','Liepoja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'LU','Ludzas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'MA','Madonas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'OG','Ogres rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'PR','Preiļu rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'RE','Rēzeknes rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'REZ','Rēzekne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'RI','Rīgas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'RIX','Rīga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'SA','Saldus rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'TA','Talsu rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'TU','Tukuma rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'VE','Ventspils rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'VEN','Ventspils');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'VK','Valkas rajons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (117,'VM','Valmieras rajons');

INSERT INTO kuu_countries VALUES (118,'Lebanon','LB','LBN',null);

INSERT INTO kuu_countries VALUES (119,'Lesotho','LS','LSO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'A','Maseru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'B','Butha-Buthe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'C','Leribe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'D','Berea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'E','Mafeteng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'F','Mohale''s Hoek');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'G','Quthing');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'H','Qacha''s Nek');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'J','Mokhotlong');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (119,'K','Thaba-Tseka');

INSERT INTO kuu_countries VALUES (120,'Liberia','LR','LBR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'BG','Bong');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'BM','Bomi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'CM','Grand Cape Mount');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'GB','Grand Bassa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'GG','Grand Gedeh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'GK','Grand Kru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'GP','Gbarpolu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'LO','Lofa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'MG','Margibi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'MO','Montserrado');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'MY','Maryland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'NI','Nimba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'RG','River Gee');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'RI','Rivercess');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (120,'SI','Sinoe');

INSERT INTO kuu_countries VALUES (121,'Libyan Arab Jamahiriya','LY','LBY',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'AJ','Ajdābiyā');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'BA','Banghāzī');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'BU','Al Buţnān');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'BW','Banī Walīd');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'DR','Darnah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'GD','Ghadāmis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'GR','Gharyān');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'GT','Ghāt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'HZ','Al Ḩizām al Akhḑar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'JA','Al Jabal al Akhḑar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'JB','Jaghbūb');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'JI','Al Jifārah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'JU','Al Jufrah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'KF','Al Kufrah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'MB','Al Marqab');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'MI','Mişrātah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'MJ','Al Marj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'MQ','Murzuq');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'MZ','Mizdah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'NL','Nālūt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'NQ','An Nuqaţ al Khams');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'QB','Al Qubbah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'QT','Al Qaţrūn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'SB','Sabhā');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'SH','Ash Shāţi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'SR','Surt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'SS','Şabrātah Şurmān');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'TB','Ţarābulus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'TM','Tarhūnah-Masallātah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'TN','Tājūrā wa an Nawāḩī al Arbāʻ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'WA','Al Wāḩah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'WD','Wādī al Ḩayāt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'YJ','Yafran-Jādū');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (121,'ZA','Az Zāwiyah');

INSERT INTO kuu_countries VALUES (122,'Liechtenstein','LI','LIE',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'B','Balzers');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'E','Eschen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'G','Gamprin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'M','Mauren');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'P','Planken');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'R','Ruggell');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'A','Schaan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'L','Schellenberg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'N','Triesen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'T','Triesenberg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (122,'V','Vaduz');

INSERT INTO kuu_countries VALUES (123,'Lithuania','LT','LTU',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'AL','Alytaus Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'KL','Klaipėdos Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'KU','Kauno Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'MR','Marijampolės Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'PN','Panevėžio Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'SA','Šiaulių Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'TA','Tauragės Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'TE','Telšių Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'UT','Utenos Apskritis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (123,'VL','Vilniaus Apskritis');

INSERT INTO kuu_countries VALUES (124,'Luxembourg','LU','LUX',E':name\n:street_address\nL-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (124,'D','Diekirch');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (124,'G','Grevenmacher');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (124,'L','Luxemburg');

INSERT INTO kuu_countries VALUES (125,'Macau','MO','MAC',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (125,'I','海島市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (125,'M','澳門市');

INSERT INTO kuu_countries VALUES (126,'Macedonia','MK','MKD',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'BR','Berovo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'CH','Чешиново-Облешево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DL','Делчево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KB','Карбинци');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'OC','Кочани');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'LO','Лозово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'MK','Македонска каменица');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'PH','Пехчево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'PT','Пробиштип');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'ST','Штип');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'SL','Свети Николе');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'NI','Виница');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'ZR','Зрновци');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KY','Кратово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KZ','Крива Паланка');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'UM','Куманово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'LI','Липково');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'RN','Ранковце');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'NA','Старо Нагоричане');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'TL','Битола');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DM','Демир Хисар');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DE','Долнени');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KG','Кривогаштани');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KS','Крушево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'MG','Могила');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'NV','Новаци');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'PP','Прилеп');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'RE','Ресен');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VJ','Боговиње');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'BN','Брвеница');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'GT','Гостивар');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'JG','Јегуновце');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'MR','Маврово и Ростуша');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'TR','Теарце');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'ET','Тетово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VH','Врапчиште');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'ZE','Желино');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'AD','Аеродром');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'AR','Арачиново');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'BU','Бутел');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'CI','Чаир');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'CE','Центар');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'CS','Чучер Сандево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'GB','Гази Баба');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'GP','Ѓорче Петров');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'IL','Илинден');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KX','Карпош');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VD','Кисела Вода');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'PE','Петровец');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'AJ','Сарај');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'SS','Сопиште');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'SU','Студеничани');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'SO','Шуто Оризари');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'ZK','Зелениково');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'BG','Богданци');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'BS','Босилово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'GV','Гевгелија');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KN','Конче');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'NS','Ново Село');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'RV','Радовиш');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'SD','Стар Дојран');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'RU','Струмица');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VA','Валандово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VL','Василево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'CZ','Центар Жупа');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DB','Дебар');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DA','Дебарца');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DR','Другово');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'KH','Кичево');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'MD','Македонски Брод');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'OD','Охрид');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'OS','Осломеј');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'PN','Пласница');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'UG','Струга');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VV','Вевчани');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VC','Вранештица');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'ZA','Зајас');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'CA','Чашка');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'DK','Демир Капија');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'GR','Градско');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'AV','Кавадарци');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'NG','Неготино');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'RM','Росоман');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (126,'VE','Велес');

INSERT INTO kuu_countries VALUES (127,'Madagascar','MG','MDG',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (127,'A','Toamasina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (127,'D','Antsiranana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (127,'F','Fianarantsoa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (127,'M','Mahajanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (127,'T','Antananarivo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (127,'U','Toliara');

INSERT INTO kuu_countries VALUES (128,'Malawi','MW','MWI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'BA','Balaka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'BL','Blantyre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'C','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'CK','Chikwawa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'CR','Chiradzulu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'CT','Chitipa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'DE','Dedza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'DO','Dowa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'KR','Karonga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'KS','Kasungu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'LK','Likoma Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'LI','Lilongwe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'MH','Machinga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'MG','Mangochi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'MC','Mchinji');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'MU','Mulanje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'MW','Mwanza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'MZ','Mzimba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'N','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'NB','Nkhata');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'NK','Nkhotakota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'NS','Nsanje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'NU','Ntcheu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'NI','Ntchisi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'PH','Phalombe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'RU','Rumphi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'S','Southern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'SA','Salima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'TH','Thyolo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (128,'ZO','Zomba');

INSERT INTO kuu_countries VALUES (129,'Malaysia','MY','MYS',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'01','Johor Darul Takzim');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'02','Kedah Darul Aman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'03','Kelantan Darul Naim');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'04','Melaka Negeri Bersejarah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'05','Negeri Sembilan Darul Khusus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'06','Pahang Darul Makmur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'07','Pulau Pinang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'08','Perak Darul Ridzuan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'09','Perlis Indera Kayangan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'10','Selangor Darul Ehsan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'11','Terengganu Darul Iman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'12','Sabah Negeri Di Bawah Bayu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'13','Sarawak Bumi Kenyalang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'14','Wilayah Persekutuan Kuala Lumpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'15','Wilayah Persekutuan Labuan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (129,'16','Wilayah Persekutuan Putrajaya');

INSERT INTO kuu_countries VALUES (130,'Maldives','MV','MDV',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'THU','Thiladhunmathi Uthuru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'THD','Thiladhunmathi Dhekunu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'MLU','Miladhunmadulu Uthuru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'MLD','Miladhunmadulu Dhekunu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'MAU','Maalhosmadulu Uthuru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'MAD','Maalhosmadulu Dhekunu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'FAA','Faadhippolhu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'MAA','Male Atoll');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'AAU','Ari Atoll Uthuru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'AAD','Ari Atoll Dheknu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'FEA','Felidhe Atoll');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'MUA','Mulaku Atoll');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'NAU','Nilandhe Atoll Uthuru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'NAD','Nilandhe Atoll Dhekunu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'KLH','Kolhumadulu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'HDH','Hadhdhunmathi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'HAU','Huvadhu Atoll Uthuru');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'HAD','Huvadhu Atoll Dhekunu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'FMU','Fua Mulaku');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (130,'ADD','Addu');

INSERT INTO kuu_countries VALUES (131,'Mali','ML','MLI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'1','Kayes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'2','Koulikoro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'3','Sikasso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'4','Ségou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'5','Mopti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'6','Tombouctou');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'7','Gao');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'8','Kidal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (131,'BK0','Bamako');

INSERT INTO kuu_countries VALUES (132,'Malta','MT','MLT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ATT','Attard');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'BAL','Balzan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'BGU','Birgu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'BKK','Birkirkara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'BRZ','Birzebbuga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'BOR','Bormla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'DIN','Dingli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'FGU','Fgura');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'FLO','Floriana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GDJ','Gudja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GZR','Gzira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GRG','Gargur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GXQ','Gaxaq');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'HMR','Hamrun');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'IKL','Iklin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ISL','Isla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'KLK','Kalkara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'KRK','Kirkop');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'LIJ','Lija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'LUQ','Luqa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MRS','Marsa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MKL','Marsaskala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MXL','Marsaxlokk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MDN','Mdina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MEL','Melliea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MGR','Mgarr');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MST','Mosta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MQA','Mqabba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MSI','Msida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MTF','Mtarfa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'NAX','Naxxar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'PAO','Paola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'PEM','Pembroke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'PIE','Pieta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'QOR','Qormi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'QRE','Qrendi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'RAB','Rabat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SAF','Safi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SGI','San Giljan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SLU','Santa Lucija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SPB','San Pawl il-Bahar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SGW','San Gwann');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SVE','Santa Venera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SIG','Siggiewi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SLM','Sliema');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SWQ','Swieqi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'TXB','Ta Xbiex');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'TRX','Tarxien');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'VLT','Valletta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'XGJ','Xgajra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ZBR','Zabbar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ZBG','Zebbug');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ZJT','Zejtun');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ZRQ','Zurrieq');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'FNT','Fontana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GHJ','Ghajnsielem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GHR','Gharb');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'GHS','Ghasri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'KRC','Kercem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'MUN','Munxar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'NAD','Nadur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'QAL','Qala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'VIC','Victoria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SLA','San Lawrenz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'SNT','Sannat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ZAG','Xagra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'XEW','Xewkija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (132,'ZEB','Zebbug');

INSERT INTO kuu_countries VALUES (133,'Marshall Islands','MH','MHL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'ALK','Ailuk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'ALL','Ailinglapalap');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'ARN','Arno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'AUR','Aur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'EBO','Ebon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'ENI','Eniwetok');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'JAB','Jabat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'JAL','Jaluit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'KIL','Kili');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'KWA','Kwajalein');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'LAE','Lae');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'LIB','Lib');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'LIK','Likiep');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'MAJ','Majuro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'MAL','Maloelap');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'MEJ','Mejit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'MIL','Mili');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'NMK','Namorik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'NMU','Namu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'RON','Rongelap');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'UJA','Ujae');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'UJL','Ujelang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'UTI','Utirik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'WTJ','Wotje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (133,'WTN','Wotho');

INSERT INTO kuu_countries VALUES (134,'Martinique','MQ','MTQ',null);

INSERT INTO kuu_countries VALUES (135,'Mauritania','MR','MRT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'01','ولاية الحوض الشرقي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'02','ولاية الحوض الغربي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'03','ولاية العصابة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'04','ولاية كركول');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'05','ولاية البراكنة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'06','ولاية الترارزة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'07','ولاية آدرار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'08','ولاية داخلت نواذيبو');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'09','ولاية تكانت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'10','ولاية كيدي ماغة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'11','ولاية تيرس زمور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'12','ولاية إينشيري');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (135,'NKC','نواكشوط');

INSERT INTO kuu_countries VALUES (136,'Mauritius','MU','MUS',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'AG','Agalega Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'BL','Black River');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'BR','Beau Bassin-Rose Hill');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'CC','Cargados Carajos Shoals');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'CU','Curepipe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'FL','Flacq');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'GP','Grand Port');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'MO','Moka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'PA','Pamplemousses');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'PL','Port Louis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'PU','Port Louis City');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'PW','Plaines Wilhems');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'QB','Quatre Bornes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'RO','Rodrigues');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'RR','Riviere du Rempart');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'SA','Savanne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (136,'VP','Vacoas-Phoenix');

INSERT INTO kuu_countries VALUES (137,'Mayotte','YT','MYT',null);

INSERT INTO kuu_countries VALUES (138,'Mexico','MX','MEX',E':name\n:street_address\n:postcode :city, :state_code\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'AGU','Aguascalientes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'BCN','Baja California');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'BCS','Baja California Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'CAM','Campeche');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'CHH','Chihuahua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'CHP','Chiapas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'COA','Coahuila');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'COL','Colima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'DIF','Distrito Federal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'DUR','Durango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'GRO','Guerrero');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'GUA','Guanajuato');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'HID','Hidalgo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'JAL','Jalisco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'MEX','Mexico');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'MIC','Michoacán');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'MOR','Morelos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'NAY','Nayarit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'NLE','Nuevo León');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'OAX','Oaxaca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'PUE','Puebla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'QUE','Querétaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'ROO','Quintana Roo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'SIN','Sinaloa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'SLP','San Luis Potosí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'SON','Sonora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'TAB','Tabasco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'TAM','Tamaulipas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'TLA','Tlaxcala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'VER','Veracruz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'YUC','Yucatan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (138,'ZAC','Zacatecas');

INSERT INTO kuu_countries VALUES (139,'Micronesia','FM','FSM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (139,'KSA','Kosrae');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (139,'PNI','Pohnpei');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (139,'TRK','Chuuk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (139,'YAP','Yap');

INSERT INTO kuu_countries VALUES (140,'Moldova','MD','MDA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'BA','Bălţi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'CA','Cahul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'CU','Chişinău');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'ED','Edineţ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'GA','Găgăuzia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'LA','Lăpuşna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'OR','Orhei');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'SN','Stânga Nistrului');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'SO','Soroca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'TI','Tighina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (140,'UN','Ungheni');

INSERT INTO kuu_countries VALUES (141,'Monaco','MC','MCO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'MC','Monte Carlo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'LR','La Rousse');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'LA','Larvotto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'MV','Monaco Ville');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'SM','Saint Michel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'CO','Condamine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'LC','La Colle');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'RE','Les Révoires');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'MO','Moneghetti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (141,'FV','Fontvieille');

INSERT INTO kuu_countries VALUES (142,'Mongolia','MN','MNG',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'1','Улаанбаатар');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'035','Орхон аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'037','Дархан-Уул аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'039','Хэнтий аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'041','Хөвсгөл аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'043','Ховд аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'046','Увс аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'047','Төв аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'049','Сэлэнгэ аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'051','Сүхбаатар аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'053','Өмнөговь аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'055','Өвөрхангай аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'057','Завхан аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'059','Дундговь аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'061','Дорнод аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'063','Дорноговь аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'064','Говьсүмбэр аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'065','Говь-Алтай аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'067','Булган аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'069','Баянхонгор аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'071','Баян Өлгий аймаг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (142,'073','Архангай аймаг');

INSERT INTO kuu_countries VALUES (143,'Montserrat','MS','MSR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (143,'A','Saint Anthony');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (143,'G','Saint Georges');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (143,'P','Saint Peter');

INSERT INTO kuu_countries VALUES (144,'Morocco','MA','MAR',null);

INSERT INTO kuu_countries VALUES (145,'Mozambique','MZ','MOZ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'A','Niassa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'B','Manica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'G','Gaza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'I','Inhambane');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'L','Maputo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'MPM','Maputo cidade');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'N','Nampula');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'P','Cabo Delgado');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'Q','Zambézia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'S','Sofala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (145,'T','Tete');

INSERT INTO kuu_countries VALUES (146,'Myanmar','MM','MMR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'AY','ဧရာ၀တီတိုင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'BG','ပဲခူးတုိင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'MG','မကေ္ဝးတိုင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'MD','မန္တလေးတုိင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'SG','စစ္‌ကုိင္‌း‌တုိင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'TN','တနင္သာရိတုိင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'YG','ရန္‌ကုန္‌တုိင္‌း');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'CH','ခ္ယင္‌းပ္ရည္‌နယ္‌');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'KC','ကခ္ယင္‌ပ္ရည္‌နယ္‌');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'KH','ကယား‌ပ္ရည္‌နယ္‌');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'KN','ကရင္‌‌ပ္ရည္‌နယ္‌');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'MN','မ္ဝန္‌ပ္ရည္‌နယ္‌');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'RK','ရခုိင္‌ပ္ရည္‌နယ္‌');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (146,'SH','ရုမ္‌းပ္ရည္‌နယ္‌');

INSERT INTO kuu_countries VALUES (147,'Namibia','NA','NAM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'CA','Caprivi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'ER','Erongo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'HA','Hardap');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'KA','Karas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'KH','Khomas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'KU','Kunene');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'OD','Otjozondjupa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'OH','Omaheke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'OK','Okavango');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'ON','Oshana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'OS','Omusati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'OT','Oshikoto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (147,'OW','Ohangwena');

INSERT INTO kuu_countries VALUES (148,'Nauru','NR','NRU',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'AO','Aiwo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'AA','Anabar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'AT','Anetan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'AI','Anibare');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'BA','Baiti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'BO','Boe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'BU','Buada');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'DE','Denigomodu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'EW','Ewa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'IJ','Ijuw');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'ME','Meneng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'NI','Nibok');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'UA','Uaboe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (148,'YA','Yaren');

INSERT INTO kuu_countries VALUES (149,'Nepal','NP','NPL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'BA','Bagmati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'BH','Bheri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'DH','Dhawalagiri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'GA','Gandaki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'JA','Janakpur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'KA','Karnali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'KO','Kosi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'LU','Lumbini');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'MA','Mahakali');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'ME','Mechi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'NA','Narayani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'RA','Rapti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'SA','Sagarmatha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (149,'SE','Seti');

INSERT INTO kuu_countries VALUES (150,'Netherlands','NL','NLD',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'DR','Drenthe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'FL','Flevoland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'FR','Friesland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'GE','Gelderland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'GR','Groningen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'LI','Limburg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'NB','Noord-Brabant');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'NH','Noord-Holland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'OV','Overijssel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'UT','Utrecht');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'ZE','Zeeland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (150,'ZH','Zuid-Holland');

INSERT INTO kuu_countries VALUES (151,'Netherlands Antilles','AN','ANT',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_countries VALUES (152,'New Caledonia','NC','NCL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (152,'L','Province des Îles');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (152,'N','Province Nord');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (152,'S','Province Sud');

INSERT INTO kuu_countries VALUES (153,'New Zealand','NZ','NZL',E':name\n:street_address\n:suburb\n:city :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'AUK','Auckland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'BOP','Bay of Plenty');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'CAN','Canterbury');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'GIS','Gisborne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'HKB','Hawke''s Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'MBH','Marlborough');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'MWT','Manawatu-Wanganui');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'NSN','Nelson');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'NTL','Northland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'OTA','Otago');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'STL','Southland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'TAS','Tasman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'TKI','Taranaki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'WGN','Wellington');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'WKO','Waikato');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (153,'WTC','West Coast');

INSERT INTO kuu_countries VALUES (154,'Nicaragua','NI','NIC',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'AN','Atlántico Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'AS','Atlántico Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'BO','Boaco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'CA','Carazo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'CI','Chinandega');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'CO','Chontales');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'ES','Estelí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'GR','Granada');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'JI','Jinotega');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'LE','León');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'MD','Madriz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'MN','Managua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'MS','Masaya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'MT','Matagalpa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'NS','Nueva Segovia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'RI','Rivas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (154,'SJ','Río San Juan');

INSERT INTO kuu_countries VALUES (155,'Niger','NE','NER',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'1','Agadez');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'2','Daffa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'3','Dosso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'4','Maradi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'5','Tahoua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'6','Tillabéry');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'7','Zinder');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (155,'8','Niamey');

INSERT INTO kuu_countries VALUES (156,'Nigeria','NG','NGA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'AB','Abia State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'AD','Adamawa State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'AK','Akwa Ibom State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'AN','Anambra State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'BA','Bauchi State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'BE','Benue State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'BO','Borno State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'BY','Bayelsa State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'CR','Cross River State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'DE','Delta State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'EB','Ebonyi State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'ED','Edo State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'EK','Ekiti State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'EN','Enugu State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'GO','Gombe State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'IM','Imo State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'JI','Jigawa State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'KB','Kebbi State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'KD','Kaduna State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'KN','Kano State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'KO','Kogi State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'KT','Katsina State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'KW','Kwara State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'LA','Lagos State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'NA','Nassarawa State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'NI','Niger State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'OG','Ogun State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'ON','Ondo State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'OS','Osun State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'OY','Oyo State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'PL','Plateau State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'RI','Rivers State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'SO','Sokoto State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'TA','Taraba State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (156,'ZA','Zamfara State');

INSERT INTO kuu_countries VALUES (157,'Niue','NU','NIU',null);
INSERT INTO kuu_countries VALUES (158,'Norfolk Island','NF','NFK',null);

INSERT INTO kuu_countries VALUES (159,'Northern Mariana Islands','MP','MNP',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (159,'N','Northern Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (159,'R','Rota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (159,'S','Saipan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (159,'T','Tinian');

INSERT INTO kuu_countries VALUES (160,'Norway','NO','NOR',E':name\n:street_address\nNO-:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'01','Østfold fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'02','Akershus fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'03','Oslo fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'04','Hedmark fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'05','Oppland fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'06','Buskerud fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'07','Vestfold fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'08','Telemark fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'09','Aust-Agder fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'10','Vest-Agder fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'11','Rogaland fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'12','Hordaland fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'14','Sogn og Fjordane fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'15','Møre og Romsdal fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'16','Sør-Trøndelag fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'17','Nord-Trøndelag fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'18','Nordland fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'19','Troms fylke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (160,'20','Finnmark fylke');

INSERT INTO kuu_countries VALUES (161,'Oman','OM','OMN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'BA','الباطنة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'DA','الداخلية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'DH','ظفار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'MA','مسقط');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'MU','مسندم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'SH','الشرقية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'WU','الوسطى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (161,'ZA','الظاهرة');

INSERT INTO kuu_countries VALUES (162,'Pakistan','PK','PAK',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'BA','بلوچستان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'IS','وفاقی دارالحکومت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'JK','آزاد کشمیر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'NA','شمالی علاقہ جات');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'NW','شمال مغربی سرحدی صوبہ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'PB','پنجاب');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'SD','سندھ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (162,'TA','وفاقی قبائلی علاقہ جات');

INSERT INTO kuu_countries VALUES (163,'Palau','PW','PLW',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'AM','Aimeliik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'AR','Airai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'AN','Angaur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'HA','Hatohobei');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'KA','Kayangel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'KO','Koror');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'ME','Melekeok');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'NA','Ngaraard');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'NG','Ngarchelong');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'ND','Ngardmau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'NT','Ngatpang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'NC','Ngchesar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'NR','Ngeremlengui');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'NW','Ngiwal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'PE','Peleliu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (163,'SO','Sonsorol');

INSERT INTO kuu_countries VALUES (164,'Panama','PA','PAN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'1','Bocas del Toro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'2','Coclé');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'3','Colón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'4','Chiriquí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'5','Darién');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'6','Herrera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'7','Los Santos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'8','Panamá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'9','Veraguas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (164,'Q','Kuna Yala');

INSERT INTO kuu_countries VALUES (165,'Papua New Guinea','PG','PNG',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'CPK','Chimbu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'CPM','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'EBR','East New Britain');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'EHG','Eastern Highlands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'EPW','Enga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'ESW','East Sepik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'GPK','Gulf');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'MBA','Milne Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'MPL','Morobe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'MPM','Madang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'MRL','Manus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'NCD','National Capital District');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'NIK','New Ireland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'NPP','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'NSA','North Solomons');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'SAN','Sandaun');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'SHM','Southern Highlands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'WBK','West New Britain');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'WHM','Western Highlands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (165,'WPD','Western');

INSERT INTO kuu_countries VALUES (166,'Paraguay','PY','PRY',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'1','Concepción');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'2','San Pedro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'3','Cordillera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'4','Guairá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'5','Caaguazú');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'6','Caazapá');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'7','Itapúa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'8','Misiones');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'9','Paraguarí');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'10','Alto Paraná');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'11','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'12','Ñeembucú');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'13','Amambay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'14','Canindeyú');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'15','Presidente Hayes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'16','Alto Paraguay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'19','Boquerón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (166,'ASU','Asunción');

INSERT INTO kuu_countries VALUES (167,'Peru','PE','PER',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'AMA','Amazonas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'ANC','Ancash');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'APU','Apurímac');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'ARE','Arequipa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'AYA','Ayacucho');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'CAJ','Cajamarca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'CAL','Callao');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'CUS','Cuzco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'HUC','Huánuco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'HUV','Huancavelica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'ICA','Ica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'JUN','Junín');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'LAL','La Libertad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'LAM','Lambayeque');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'LIM','Lima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'LOR','Loreto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'MDD','Madre de Dios');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'MOQ','Moquegua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'PAS','Pasco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'PIU','Piura');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'PUN','Puno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'SAM','San Martín');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'TAC','Tacna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'TUM','Tumbes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (167,'UCA','Ucayali');

INSERT INTO kuu_countries VALUES (168,'Philippines','PH','PHL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ABR','Abra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'AGN','Agusan del Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'AGS','Agusan del Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'AKL','Aklan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ALB','Albay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ANT','Antique');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'APA','Apayao');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'AUR','Aurora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BAN','Bataan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BAS','Basilan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BEN','Benguet');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BIL','Biliran');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BOH','Bohol');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BTG','Batangas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BTN','Batanes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BUK','Bukidnon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'BUL','Bulacan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAG','Cagayan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAM','Camiguin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAN','Camarines Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAP','Capiz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAS','Camarines Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAT','Catanduanes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CAV','Cavite');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'CEB','Cebu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'COM','Compostela Valley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'DAO','Davao Oriental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'DAS','Davao del Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'DAV','Davao del Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'EAS','Eastern Samar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'GUI','Guimaras');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'IFU','Ifugao');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ILI','Iloilo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ILN','Ilocos Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ILS','Ilocos Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ISA','Isabela');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'KAL','Kalinga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'LAG','Laguna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'LAN','Lanao del Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'LAS','Lanao del Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'LEY','Leyte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'LUN','La Union');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MAD','Marinduque');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MAG','Maguindanao');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MAS','Masbate');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MDC','Mindoro Occidental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MDR','Mindoro Oriental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MOU','Mountain Province');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MSC','Misamis Occidental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'MSR','Misamis Oriental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'NCO','Cotabato');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'NSA','Northern Samar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'NEC','Negros Occidental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'NER','Negros Oriental');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'NUE','Nueva Ecija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'NUV','Nueva Vizcaya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'PAM','Pampanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'PAN','Pangasinan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'PLW','Palawan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'QUE','Quezon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'QUI','Quirino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'RIZ','Rizal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ROM','Romblon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SAR','Sarangani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SCO','South Cotabato');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SIG','Siquijor');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SLE','Southern Leyte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SLU','Sulu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SOR','Sorsogon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SUK','Sultan Kudarat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SUN','Surigao del Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'SUR','Surigao del Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'TAR','Tarlac');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'TAW','Tawi-Tawi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'WSA','Samar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ZAN','Zamboanga del Norte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ZAS','Zamboanga del Sur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ZMB','Zambales');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (168,'ZSI','Zamboanga Sibugay');

INSERT INTO kuu_countries VALUES (169,'Pitcairn','PN','PCN',null);

INSERT INTO kuu_countries VALUES (170,'Poland','PL','POL',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'DS','Dolnośląskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'KP','Kujawsko-Pomorskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'LU','Lubelskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'LB','Lubuskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'LD','Łódzkie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'MA','Małopolskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'MZ','Mazowieckie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'OP','Opolskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'PK','Podkarpackie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'PD','Podlaskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'PM','Pomorskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'SL','Śląskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'SK','Świętokrzyskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'WN','Warmińsko-Mazurskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'WP','Wielkopolskie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (170,'ZP','Zachodniopomorskie');

INSERT INTO kuu_countries VALUES (171,'Portugal','PT','PRT',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'01','Aveiro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'02','Beja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'03','Braga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'04','Bragança');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'05','Castelo Branco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'06','Coimbra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'07','Évora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'08','Faro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'09','Guarda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'10','Leiria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'11','Lisboa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'12','Portalegre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'13','Porto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'14','Santarém');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'15','Setúbal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'16','Viana do Castelo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'17','Vila Real');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'18','Viseu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'20','Região Autónoma dos Açores');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (171,'30','Região Autónoma da Madeira');

INSERT INTO kuu_countries VALUES (172,'Puerto Rico','PR','PRI',null);

INSERT INTO kuu_countries VALUES (173,'Qatar','QA','QAT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'DA','الدوحة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'GH','الغويرية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'JB','جريان الباطنة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'JU','الجميلية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'KH','الخور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'ME','مسيعيد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'MS','الشمال');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'RA','الريان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'US','أم صلال');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (173,'WA','الوكرة');

INSERT INTO kuu_countries VALUES (174,'Reunion','RE','REU',null);

INSERT INTO kuu_countries VALUES (175,'Romania','RO','ROM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'AB','Alba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'AG','Argeş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'AR','Arad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'B','Bucureşti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BC','Bacău');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BH','Bihor');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BN','Bistriţa-Năsăud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BR','Brăila');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BT','Botoşani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BV','Braşov');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'BZ','Buzău');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'CJ','Cluj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'CL','Călăraşi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'CS','Caraş-Severin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'CT','Constanţa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'CV','Covasna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'DB','Dâmboviţa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'DJ','Dolj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'GJ','Gorj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'GL','Galaţi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'GR','Giurgiu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'HD','Hunedoara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'HG','Harghita');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'IF','Ilfov');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'IL','Ialomiţa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'IS','Iaşi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'MH','Mehedinţi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'MM','Maramureş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'MS','Mureş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'NT','Neamţ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'OT','Olt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'PH','Prahova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'SB','Sibiu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'SJ','Sălaj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'SM','Satu Mare');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'SV','Suceava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'TL','Tulcea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'TM','Timiş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'TR','Teleorman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'VL','Vâlcea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'VN','Vrancea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (175,'VS','Vaslui');

INSERT INTO kuu_countries VALUES (176,'Russia','RU','RUS',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'AD','Адыге́я Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'AGB','Аги́нский-Буря́тский автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'AL','Алта́й Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ALT','Алта́йский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'AMU','Аму́рская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ARK','Арха́нгельская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'AST','Астраха́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'BA','Башкортоста́н Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'BEL','Белгоро́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'BRY','Бря́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'BU','Буря́тия Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'CE','Чече́нская Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'CHE','Челя́бинская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'CHI','Чити́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'CHU','Чуко́тский автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'CU','Чува́шская Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'DA','Дагеста́н Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'EVE','Эвенки́йский автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'IN','Ингуше́тия Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'IRK','Ирку́тская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'IVA','Ива́новская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KAM','Камча́тская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KB','Кабарди́но-Балка́рская Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KC','Карача́ево-Черке́сская Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KDA','Краснода́рский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KEM','Ке́меровская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KGD','Калинингра́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KGN','Курга́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KHA','Хаба́ровский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KHM','Ха́нты-Манси́йский автоно́мный о́круг—Югра́');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KIA','Красноя́рский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KIR','Ки́ровская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KK','Хака́сия');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KL','Калмы́кия Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KLU','Калу́жская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KO','Ко́ми Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KOR','Коря́кский автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KOS','Костромска́я о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KR','Каре́лия Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'KRS','Ку́рская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'LEN','Ленингра́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'LIP','Ли́пецкая о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'MAG','Магада́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ME','Мари́й Эл Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'MO','Мордо́вия Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'MOS','Моско́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'MOW','Москва́');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'MUR','Му́рманская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'NEN','Нене́цкий автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'NGR','Новгоро́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'NIZ','Нижегоро́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'NVS','Новосиби́рская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'OMS','О́мская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ORE','Оренбу́ргская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ORL','Орло́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'PNZ','Пе́нзенская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'PRI','Примо́рский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'PSK','Пско́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ROS','Росто́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'RYA','Ряза́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SA','Саха́ (Яку́тия) Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SAK','Сахали́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SAM','Сама́рская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SAR','Сара́товская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SE','Се́верная Осе́тия–Ала́ния Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SMO','Смол́енская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SPE','Санкт-Петербу́рг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'STA','Ставропо́льский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'SVE','Свердло́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TA','Респу́блика Татарста́н');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TAM','Тамбо́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TAY','Таймы́рский автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TOM','То́мская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TUL','Ту́льская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TVE','Тверска́я о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TY','Тыва́ Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'TYU','Тюме́нская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'UD','Удму́ртская Респу́блика');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'ULY','Улья́новская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'UOB','Усть-Орды́нский Буря́тский автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'VGG','Волгогра́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'VLA','Влади́мирская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'VLG','Волого́дская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'VOR','Воро́нежская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'XXX','Пе́рмский край');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'YAN','Яма́ло-Нене́цкий автоно́мный о́круг');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'YAR','Яросла́вская о́бласть');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (176,'YEV','Евре́йская автоно́мная о́бласть');

INSERT INTO kuu_countries VALUES (177,'Rwanda','RW','RWA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (177,'N','Nord');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (177,'E','Est');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (177,'S','Sud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (177,'O','Ouest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (177,'K','Kigali');

INSERT INTO kuu_countries VALUES (178,'Saint Kitts and Nevis','KN','KNA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (178,'K','Saint Kitts');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (178,'N','Nevis');

INSERT INTO kuu_countries VALUES (179,'Saint Lucia','LC','LCA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'AR','Anse-la-Raye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'CA','Castries');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'CH','Choiseul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'DA','Dauphin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'DE','Dennery');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'GI','Gros-Islet');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'LA','Laborie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'MI','Micoud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'PR','Praslin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'SO','Soufriere');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (179,'VF','Vieux-Fort');

INSERT INTO kuu_countries VALUES (180,'Saint Vincent and the Grenadines','VC','VCT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (180,'C','Charlotte');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (180,'R','Grenadines');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (180,'A','Saint Andrew');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (180,'D','Saint David');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (180,'G','Saint George');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (180,'P','Saint Patrick');

INSERT INTO kuu_countries VALUES (181,'Samoa','WS','WSM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'AA','A''ana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'AL','Aiga-i-le-Tai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'AT','Atua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'FA','Fa''asaleleaga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'GE','Gaga''emauga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'GI','Gaga''ifomauga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'PA','Palauli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'SA','Satupa''itea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'TU','Tuamasaga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'VF','Va''a-o-Fonoti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (181,'VS','Vaisigano');

INSERT INTO kuu_countries VALUES (182,'San Marino','SM','SMR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'AC','Acquaviva');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'BM','Borgo Maggiore');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'CH','Chiesanuova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'DO','Domagnano');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'FA','Faetano');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'FI','Fiorentino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'MO','Montegiardino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'SM','Citta di San Marino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (182,'SE','Serravalle');

INSERT INTO kuu_countries VALUES (183,'Sao Tome and Principe','ST','STP',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (183,'P','Príncipe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (183,'S','São Tomé');

INSERT INTO kuu_countries VALUES (184,'Saudi Arabia','SA','SAU',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'01','الرياض');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'02','مكة المكرمة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'03','المدينه');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'04','الشرقية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'05','القصيم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'06','حائل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'07','تبوك');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'08','الحدود الشمالية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'09','جيزان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'10','نجران');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'11','الباحة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'12','الجوف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (184,'14','عسير');

INSERT INTO kuu_countries VALUES (185,'Senegal','SN','SEN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'DA','Dakar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'DI','Diourbel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'FA','Fatick');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'KA','Kaolack');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'KO','Kolda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'LO','Louga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'MA','Matam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'SL','Saint-Louis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'TA','Tambacounda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'TH','Thies ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (185,'ZI','Ziguinchor');

INSERT INTO kuu_countries VALUES (186,'Seychelles','SC','SYC',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'AP','Anse aux Pins');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'AB','Anse Boileau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'AE','Anse Etoile');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'AL','Anse Louis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'AR','Anse Royale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'BL','Baie Lazare');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'BS','Baie Sainte Anne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'BV','Beau Vallon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'BA','Bel Air');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'BO','Bel Ombre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'CA','Cascade');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'GL','Glacis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'GM','Grand'' Anse (on Mahe)');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'GP','Grand'' Anse (on Praslin)');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'DG','La Digue');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'RA','La Riviere Anglaise');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'MB','Mont Buxton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'MF','Mont Fleuri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'PL','Plaisance');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'PR','Pointe La Rue');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'PG','Port Glaud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'SL','Saint Louis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (186,'TA','Takamaka');

INSERT INTO kuu_countries VALUES (187,'Sierra Leone','SL','SLE',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (187,'E','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (187,'N','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (187,'S','Southern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (187,'W','Western');

INSERT INTO kuu_countries VALUES (188,'Singapore','SG','SGP', E':name\n:street_address\n:city :postcode\n:country');

INSERT INTO kuu_countries VALUES (189,'Slovakia','SK','SVK',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'BC','Banskobystrický kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'BL','Bratislavský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'KI','Košický kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'NJ','Nitrianský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'PV','Prešovský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'TA','Trnavský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'TC','Trenčianský kraj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (189,'ZI','Žilinský kraj');

INSERT INTO kuu_countries VALUES (190,'Slovenia','SI','SVN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'001','Ajdovščina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'002','Beltinci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'003','Bled');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'004','Bohinj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'005','Borovnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'006','Bovec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'007','Brda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'008','Brezovica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'009','Brežice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'010','Tišina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'011','Celje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'012','Cerklje na Gorenjskem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'013','Cerknica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'014','Cerkno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'015','Črenšovci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'016','Črna na Koroškem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'017','Črnomelj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'018','Destrnik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'019','Divača');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'020','Dobrepolje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'021','Dobrova-Polhov Gradec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'022','Dol pri Ljubljani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'023','Domžale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'024','Dornava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'025','Dravograd');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'026','Duplek');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'027','Gorenja vas-Poljane');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'028','Gorišnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'029','Gornja Radgona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'030','Gornji Grad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'031','Gornji Petrovci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'032','Grosuplje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'033','Šalovci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'034','Hrastnik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'035','Hrpelje-Kozina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'036','Idrija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'037','Ig');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'038','Ilirska Bistrica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'039','Ivančna Gorica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'040','Izola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'041','Jesenice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'042','Juršinci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'043','Kamnik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'044','Kanal ob Soči');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'045','Kidričevo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'046','Kobarid');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'047','Kobilje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'048','Kočevje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'049','Komen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'050','Koper');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'051','Kozje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'052','Kranj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'053','Kranjska Gora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'054','Krško');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'055','Kungota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'056','Kuzma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'057','Laško');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'058','Lenart');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'059','Lendava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'060','Litija');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'061','Ljubljana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'062','Ljubno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'063','Ljutomer');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'064','Logatec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'065','Loška Dolina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'066','Loški Potok');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'067','Luče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'068','Lukovica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'069','Majšperk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'070','Maribor');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'071','Medvode');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'072','Mengeš');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'073','Metlika');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'074','Mežica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'075','Miren-Kostanjevica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'076','Mislinja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'077','Moravče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'078','Moravske Toplice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'079','Mozirje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'080','Murska Sobota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'081','Muta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'082','Naklo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'083','Nazarje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'084','Nova Gorica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'085','Novo mesto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'086','Odranci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'087','Ormož');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'088','Osilnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'089','Pesnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'090','Piran');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'091','Pivka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'092','Podčetrtek');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'093','Podvelka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'094','Postojna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'095','Preddvor');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'096','Ptuj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'097','Puconci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'098','Rače-Fram');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'099','Radeče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'100','Radenci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'101','Radlje ob Dravi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'102','Radovljica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'103','Ravne na Koroškem');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'104','Ribnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'106','Rogaška Slatina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'105','Rogašovci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'107','Rogatec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'108','Ruše');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'109','Semič');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'110','Sevnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'111','Sežana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'112','Slovenj Gradec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'113','Slovenska Bistrica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'114','Slovenske Konjice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'115','Starše');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'116','Sveti Jurij');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'117','Šenčur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'118','Šentilj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'119','Šentjernej');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'120','Šentjur pri Celju');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'121','Škocjan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'122','Škofja Loka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'123','Škofljica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'124','Šmarje pri Jelšah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'125','Šmartno ob Paki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'126','Šoštanj');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'127','Štore');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'128','Tolmin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'129','Trbovlje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'130','Trebnje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'131','Tržič');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'132','Turnišče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'133','Velenje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'134','Velike Lašče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'135','Videm');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'136','Vipava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'137','Vitanje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'138','Vodice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'139','Vojnik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'140','Vrhnika');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'141','Vuzenica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'142','Zagorje ob Savi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'143','Zavrč');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'144','Zreče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'146','Železniki');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'147','Žiri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'148','Benedikt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'149','Bistrica ob Sotli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'150','Bloke');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'151','Braslovče');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'152','Cankova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'153','Cerkvenjak');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'154','Dobje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'155','Dobrna');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'156','Dobrovnik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'157','Dolenjske Toplice');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'158','Grad');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'159','Hajdina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'160','Hoče-Slivnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'161','Hodoš');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'162','Horjul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'163','Jezersko');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'164','Komenda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'165','Kostel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'166','Križevci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'167','Lovrenc na Pohorju');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'168','Markovci');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'169','Miklavž na Dravskem polju');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'170','Mirna Peč');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'171','Oplotnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'172','Podlehnik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'173','Polzela');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'174','Prebold');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'175','Prevalje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'176','Razkrižje');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'177','Ribnica na Pohorju');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'178','Selnica ob Dravi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'179','Sodražica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'180','Solčava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'181','Sveta Ana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'182','Sveti Andraž v Slovenskih goricah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'183','Šempeter-Vrtojba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'184','Tabor');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'185','Trnovska vas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'186','Trzin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'187','Velika Polana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'188','Veržej');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'189','Vransko');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'190','Žalec');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'191','Žetale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'192','Žirovnica');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'193','Žužemberk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (190,'194','Šmartno pri Litiji');

INSERT INTO kuu_countries VALUES (191,'Solomon Islands','SB','SLB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'CE','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'CH','Choiseul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'GC','Guadalcanal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'HO','Honiara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'IS','Isabel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'MK','Makira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'ML','Malaita');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'RB','Rennell and Bellona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'TM','Temotu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (191,'WE','Western');

INSERT INTO kuu_countries VALUES (192,'Somalia','SO','SOM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'AD','Awdal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'BK','Bakool');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'BN','Banaadir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'BR','Bari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'BY','Bay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'GD','Gedo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'GG','Galguduud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'HR','Hiiraan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'JD','Jubbada Dhexe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'JH','Jubbada Hoose');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'MD','Mudug');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'NG','Nugaal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'SD','Shabeellaha Dhexe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'SG','Sanaag');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'SH','Shabeellaha Hoose');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'SL','Sool');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'TG','Togdheer');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (192,'WG','Woqooyi Galbeed');

INSERT INTO kuu_countries VALUES (193,'South Africa','ZA','ZAF',E':name\n:street_address\n:suburb\n:city\n:postcode :country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'EC','Eastern Cape');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'FS','Free State');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'GT','Gauteng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'LP','Limpopo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'MP','Mpumalanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'NC','Northern Cape');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'NL','KwaZulu-Natal');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'NW','North-West');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (193,'WC','Western Cape');

INSERT INTO kuu_countries VALUES (194,'South Georgia and the South Sandwich Islands','GS','SGS',null);

INSERT INTO kuu_countries VALUES (195,'Spain','ES','ESP',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'AN','Andalucía');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'AR','Aragón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'A','Alicante');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'AB','Albacete');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'AL','Almería');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'AN','Andalucía');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'AV','Ávila');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'B','Barcelona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'BA','Badajoz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'BI','Vizcaya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'BU','Burgos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'C','A Coruña');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CA','Cádiz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CC','Cáceres');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CE','Ceuta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CL','Castilla y León');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CM','Castilla-La Mancha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CN','Islas Canarias');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CO','Córdoba');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CR','Ciudad Real');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CS','Castellón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CT','Catalonia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'CU','Cuenca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'EX','Extremadura');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'GA','Galicia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'GC','Las Palmas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'GI','Girona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'GR','Granada');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'GU','Guadalajara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'H','Huelva');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'HU','Huesca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'IB','Islas Baleares');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'J','Jaén');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'L','Lleida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'LE','León');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'LO','La Rioja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'LU','Lugo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'M','Madrid');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'MA','Málaga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'ML','Melilla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'MU','Murcia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'NA','Navarre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'O','Asturias');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'OR','Ourense');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'P','Palencia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'PM','Baleares');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'PO','Pontevedra');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'PV','Basque Euskadi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'S','Cantabria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'SA','Salamanca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'SE','Seville');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'SG','Segovia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'SO','Soria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'SS','Guipúzcoa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'T','Tarragona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'TE','Teruel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'TF','Santa Cruz De Tenerife');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'TO','Toledo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'V','Valencia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'VA','Valladolid');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'VI','Álava');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'Z','Zaragoza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (195,'ZA','Zamora');

INSERT INTO kuu_countries VALUES (196,'Sri Lanka','LK','LKA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'CE','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'NC','North Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'NO','North');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'EA','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'NW','North Western');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'SO','Southern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'UV','Uva');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'SA','Sabaragamuwa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (196,'WE','Western');

INSERT INTO kuu_countries VALUES (197,'St. Helena','SH','SHN',null);
INSERT INTO kuu_countries VALUES (198,'St. Pierre and Miquelon','PM','SPM',null);

INSERT INTO kuu_countries VALUES (199,'Sudan','SD','SDN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'ANL','أعالي النيل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'BAM','البحر الأحمر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'BRT','البحيرات');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'JZR','ولاية الجزيرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'KRT','الخرطوم');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'QDR','القضارف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'WDH','الوحدة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'ANB','النيل الأبيض');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'ANZ','النيل الأزرق');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'ASH','الشمالية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'BJA','الاستوائية الوسطى');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'GIS','غرب الاستوائية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'GBG','غرب بحر الغزال');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'GDA','غرب دارفور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'GKU','غرب كردفان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'JDA','جنوب دارفور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'JKU','جنوب كردفان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'JQL','جونقلي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'KSL','كسلا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'NNL','ولاية نهر النيل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'SBG','شمال بحر الغزال');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'SDA','شمال دارفور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'SKU','شمال كردفان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'SIS','شرق الاستوائية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'SNR','سنار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (199,'WRB','واراب');

INSERT INTO kuu_countries VALUES (200,'Suriname','SR','SUR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'BR','Brokopondo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'CM','Commewijne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'CR','Coronie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'MA','Marowijne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'NI','Nickerie');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'PM','Paramaribo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'PR','Para');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'SA','Saramacca');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'SI','Sipaliwini');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (200,'WA','Wanica');

INSERT INTO kuu_countries VALUES (201,'Svalbard and Jan Mayen Islands','SJ','SJM',null);

INSERT INTO kuu_countries VALUES (202,'Swaziland','SZ','SWZ',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (202,'HH','Hhohho');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (202,'LU','Lubombo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (202,'MA','Manzini');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (202,'SH','Shiselweni');

INSERT INTO kuu_countries VALUES (203,'Sweden','SE','SWE',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'AB','Stockholms län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'C','Uppsala län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'D','Södermanlands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'E','Östergötlands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'F','Jönköpings län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'G','Kronobergs län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'H','Kalmar län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'I','Gotlands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'K','Blekinge län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'M','Skåne län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'N','Hallands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'O','Västra Götalands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'S','Värmlands län;');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'T','Örebro län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'U','Västmanlands län;');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'W','Dalarnas län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'X','Gävleborgs län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'Y','Västernorrlands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'Z','Jämtlands län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'AC','Västerbottens län');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (203,'BD','Norrbottens län');

INSERT INTO kuu_countries VALUES (204,'Switzerland','CH','CHE',E':name\n:street_address\n:postcode :city\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'ZH','Zürich');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'BE','Bern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'LU','Luzern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'UR','Uri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'SZ','Schwyz');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'OW','Obwalden');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'NW','Nidwalden');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'GL','Glasrus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'ZG','Zug');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'FR','Fribourg');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'SO','Solothurn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'BS','Basel-Stadt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'BL','Basel-Landschaft');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'SH','Schaffhausen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'AR','Appenzell Ausserrhoden');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'AI','Appenzell Innerrhoden');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'SG','Saint Gallen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'GR','Graubünden');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'AG','Aargau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'TG','Thurgau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'TI','Ticino');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'VD','Vaud');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'VS','Valais');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'NE','Nuechâtel');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'GE','Genève');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (204,'JU','Jura');

INSERT INTO kuu_countries VALUES (205,'Syrian Arab Republic','SY','SYR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'DI','دمشق');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'DR','درعا');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'DZ','دير الزور');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'HA','الحسكة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'HI','حمص');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'HL','حلب');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'HM','حماه');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'ID','ادلب');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'LA','اللاذقية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'QU','القنيطرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'RA','الرقة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'RD','ریف دمشق');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'SU','السويداء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (205,'TA','طرطوس');

INSERT INTO kuu_countries VALUES (206,'Taiwan','TW','TWN',E':name\n:street_address\n:city :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'CHA','彰化縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'CYI','嘉義市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'CYQ','嘉義縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'HSQ','新竹縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'HSZ','新竹市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'HUA','花蓮縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'ILA','宜蘭縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'KEE','基隆市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'KHH','高雄市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'KHQ','高雄縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'MIA','苗栗縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'NAN','南投縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'PEN','澎湖縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'PIF','屏東縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TAO','桃源县');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TNN','台南市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TNQ','台南縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TPE','臺北市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TPQ','臺北縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TTT','台東縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TXG','台中市');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'TXQ','台中縣');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (206,'YUN','雲林縣');

INSERT INTO kuu_countries VALUES (207,'Tajikistan','TJ','TJK',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (207,'GB','کوهستان بدخشان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (207,'KT','ختلان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (207,'SU','سغد');

INSERT INTO kuu_countries VALUES (208,'Tanzania','TZ','TZA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'01','Arusha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'02','Dar es Salaam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'03','Dodoma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'04','Iringa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'05','Kagera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'06','Pemba Sever');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'07','Zanzibar Sever');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'08','Kigoma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'09','Kilimanjaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'10','Pemba Jih');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'11','Zanzibar Jih');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'12','Lindi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'13','Mara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'14','Mbeya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'15','Zanzibar Západ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'16','Morogoro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'17','Mtwara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'18','Mwanza');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'19','Pwani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'20','Rukwa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'21','Ruvuma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'22','Shinyanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'23','Singida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'24','Tabora');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'25','Tanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (208,'26','Manyara');

INSERT INTO kuu_countries VALUES (209,'Thailand','TH','THA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-10','กรุงเทพมหานคร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-11','สมุทรปราการ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-12','นนทบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-13','ปทุมธานี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-14','พระนครศรีอยุธยา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-15','อ่างทอง');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-16','ลพบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-17','สิงห์บุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-18','ชัยนาท');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-19','สระบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-20','ชลบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-21','ระยอง');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-22','จันทบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-23','ตราด');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-24','ฉะเชิงเทรา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-25','ปราจีนบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-26','นครนายก');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-27','สระแก้ว');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-30','นครราชสีมา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-31','บุรีรัมย์');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-32','สุรินทร์');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-33','ศรีสะเกษ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-34','อุบลราชธานี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-35','ยโสธร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-36','ชัยภูมิ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-37','อำนาจเจริญ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-39','หนองบัวลำภู');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-40','ขอนแก่น');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-41','อุดรธานี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-42','เลย');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-43','หนองคาย');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-44','มหาสารคาม');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-45','ร้อยเอ็ด');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-46','กาฬสินธุ์');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-47','สกลนคร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-48','นครพนม');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-49','มุกดาหาร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-50','เชียงใหม่');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-51','ลำพูน');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-52','ลำปาง');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-53','อุตรดิตถ์');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-55','น่าน');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-56','พะเยา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-57','เชียงราย');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-58','แม่ฮ่องสอน');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-60','นครสวรรค์');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-61','อุทัยธานี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-62','กำแพงเพชร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-63','ตาก');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-64','สุโขทัย');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-66','ชุมพร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-67','พิจิตร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-70','ราชบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-71','กาญจนบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-72','สุพรรณบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-73','นครปฐม');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-74','สมุทรสาคร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-75','สมุทรสงคราม');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-76','เพชรบุรี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-77','ประจวบคีรีขันธ์');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-80','นครศรีธรรมราช');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-81','กระบี่');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-82','พังงา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-83','ภูเก็ต');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-84','สุราษฎร์ธานี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-85','ระนอง');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-86','ชุมพร');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-90','สงขลา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-91','สตูล');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-92','ตรัง');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-93','พัทลุง');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-94','ปัตตานี');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-95','ยะลา');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (209,'TH-96','นราธิวาส');

INSERT INTO kuu_countries VALUES (210,'Togo','TG','TGO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (210,'C','Centrale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (210,'K','Kara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (210,'M','Maritime');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (210,'P','Plateaux');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (210,'S','Savanes');

INSERT INTO kuu_countries VALUES (211,'Tokelau','TK','TKL',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (211,'A','Atafu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (211,'F','Fakaofo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (211,'N','Nukunonu');

INSERT INTO kuu_countries VALUES (212,'Tonga','TO','TON',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (212,'H','Ha''apai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (212,'T','Tongatapu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (212,'V','Vava''u');

INSERT INTO kuu_countries VALUES (213,'Trinidad and Tobago','TT','TTO',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'ARI','Arima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'CHA','Chaguanas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'CTT','Couva-Tabaquite-Talparo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'DMN','Diego Martin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'ETO','Eastern Tobago');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'RCM','Rio Claro-Mayaro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'PED','Penal-Debe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'PTF','Point Fortin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'POS','Port of Spain');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'PRT','Princes Town');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'SFO','San Fernando');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'SGE','Sangre Grande');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'SJL','San Juan-Laventille');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'SIP','Siparia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'TUP','Tunapuna-Piarco');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (213,'WTO','Western Tobago');

INSERT INTO kuu_countries VALUES (214,'Tunisia','TN','TUN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'11','ولاية تونس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'12','ولاية أريانة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'13','ولاية بن عروس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'14','ولاية منوبة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'21','ولاية نابل');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'22','ولاية زغوان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'23','ولاية بنزرت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'31','ولاية باجة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'32','ولاية جندوبة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'33','ولاية الكاف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'34','ولاية سليانة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'41','ولاية القيروان');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'42','ولاية القصرين');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'43','ولاية سيدي بوزيد');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'51','ولاية سوسة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'52','ولاية المنستير');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'53','ولاية المهدية');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'61','ولاية صفاقس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'71','ولاية قفصة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'72','ولاية توزر');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'73','ولاية قبلي');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'81','ولاية قابس');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'82','ولاية مدنين');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (214,'83','ولاية تطاوين');

INSERT INTO kuu_countries VALUES (215,'Turkey','TR','TUR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'01','Adana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'02','Adıyaman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'03','Afyonkarahisar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'04','Ağrı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'05','Amasya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'06','Ankara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'07','Antalya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'08','Artvin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'09','Aydın');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'10','Balıkesir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'11','Bilecik');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'12','Bingöl');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'13','Bitlis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'14','Bolu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'15','Burdur');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'16','Bursa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'17','Çanakkale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'18','Çankırı');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'19','Çorum');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'20','Denizli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'21','Diyarbakır');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'22','Edirne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'23','Elazığ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'24','Erzincan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'25','Erzurum');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'26','Eskişehir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'27','Gaziantep');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'28','Giresun');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'29','Gümüşhane');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'30','Hakkari');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'31','Hatay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'32','Isparta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'33','Mersin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'34','İstanbul');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'35','İzmir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'36','Kars');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'37','Kastamonu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'38','Kayseri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'39','Kırklareli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'40','Kırşehir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'41','Kocaeli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'42','Konya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'43','Kütahya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'44','Malatya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'45','Manisa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'46','Kahramanmaraş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'47','Mardin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'48','Muğla');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'49','Muş');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'50','Nevşehir');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'51','Niğde');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'52','Ordu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'53','Rize');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'54','Sakarya');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'55','Samsun');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'56','Siirt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'57','Sinop');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'58','Sivas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'59','Tekirdağ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'60','Tokat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'61','Trabzon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'62','Tunceli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'63','Şanlıurfa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'64','Uşak');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'65','Van');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'66','Yozgat');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'67','Zonguldak');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'68','Aksaray');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'69','Bayburt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'70','Karaman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'71','Kırıkkale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'72','Batman');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'73','Şırnak');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'74','Bartın');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'75','Ardahan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'76','Iğdır');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'77','Yalova');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'78','Karabük');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'79','Kilis');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'80','Osmaniye');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (215,'81','Düzce');

INSERT INTO kuu_countries VALUES (216,'Turkmenistan','TM','TKM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (216,'A','Ahal welaýaty');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (216,'B','Balkan welaýaty');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (216,'D','Daşoguz welaýaty');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (216,'L','Lebap welaýaty');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (216,'M','Mary welaýaty');

INSERT INTO kuu_countries VALUES (217,'Turks and Caicos Islands','TC','TCA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'AC','Ambergris Cays');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'DC','Dellis Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'FC','French Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'LW','Little Water Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'RC','Parrot Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'PN','Pine Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'SL','Salt Cay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'GT','Grand Turk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'SC','South Caicos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'EC','East Caicos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'MC','Middle Caicos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'NC','North Caicos');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'PR','Providenciales');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (217,'WC','West Caicos');

INSERT INTO kuu_countries VALUES (218,'Tuvalu','TV','TUV',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'FUN','Funafuti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'NMA','Nanumea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'NMG','Nanumanga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'NIT','Niutao');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'NIU','Nui');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'NKF','Nukufetau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'NKL','Nukulaelae');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (218,'VAI','Vaitupu');

INSERT INTO kuu_countries VALUES (219,'Uganda','UG','UGA',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'101','Kalangala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'102','Kampala');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'103','Kiboga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'104','Luwero');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'105','Masaka');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'106','Mpigi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'107','Mubende');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'108','Mukono');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'109','Nakasongola');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'110','Rakai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'111','Sembabule');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'112','Kayunga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'113','Wakiso');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'201','Bugiri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'202','Busia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'203','Iganga');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'204','Jinja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'205','Kamuli');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'206','Kapchorwa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'207','Katakwi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'208','Kumi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'209','Mbale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'210','Pallisa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'211','Soroti');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'212','Tororo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'213','Kaberamaido');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'214','Mayuge');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'215','Sironko');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'301','Adjumani');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'302','Apac');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'303','Arua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'304','Gulu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'305','Kitgum');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'306','Kotido');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'307','Lira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'308','Moroto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'309','Moyo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'310','Nebbi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'311','Nakapiripirit');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'312','Pader');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'313','Yumbe');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'401','Bundibugyo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'402','Bushenyi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'403','Hoima');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'404','Kabale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'405','Kabarole');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'406','Kasese');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'407','Kibale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'408','Kisoro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'409','Masindi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'410','Mbarara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'411','Ntungamo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'412','Rukungiri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'413','Kamwenge');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'414','Kanungu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (219,'415','Kyenjojo');

INSERT INTO kuu_countries VALUES (220,'Ukraine','UA','UKR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'05','Вінницька область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'07','Волинська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'09','Луганська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'12','Дніпропетровська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'14','Донецька область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'18','Житомирська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'19','Рівненська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'21','Закарпатська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'23','Запорізька область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'26','Івано-Франківська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'30','Київ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'32','Київська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'35','Кіровоградська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'40','Севастополь');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'43','Автономная Республика Крым');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'46','Львівська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'48','Миколаївська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'51','Одеська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'53','Полтавська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'59','Сумська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'61','Тернопільська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'63','Харківська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'65','Херсонська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'68','Хмельницька область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'71','Черкаська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'74','Чернігівська область');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (220,'77','Чернівецька область');

INSERT INTO kuu_countries VALUES (221,'United Arab Emirates','AE','ARE',null);

INSERT INTO kuu_countries VALUES (222,'United Kingdom','GB','GBR',E':name\n:street_address\n:city\n:postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ABD','Aberdeenshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ABE','Aberdeen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'AGB','Argyll and Bute');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'AGY','Isle of Anglesey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ANS','Angus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ANT','Antrim');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ARD','Ards');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ARM','Armagh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BAS','Bath and North East Somerset');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BBD','Blackburn with Darwen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BDF','Bedfordshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BDG','Barking and Dagenham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BEN','Brent');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BEX','Bexley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BFS','Belfast');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BGE','Bridgend');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BGW','Blaenau Gwent');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BIR','Birmingham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BKM','Buckinghamshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BLA','Ballymena');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BLY','Ballymoney');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BMH','Bournemouth');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BNB','Banbridge');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BNE','Barnet');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BNH','Brighton and Hove');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BNS','Barnsley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BOL','Bolton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BPL','Blackpool');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BRC','Bracknell');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BRD','Bradford');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BRY','Bromley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BST','Bristol');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'BUR','Bury');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CAM','Cambridgeshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CAY','Caerphilly');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CGN','Ceredigion');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CGV','Craigavon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CHS','Cheshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CKF','Carrickfergus');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CKT','Cookstown');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CLD','Calderdale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CLK','Clackmannanshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CLR','Coleraine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CMA','Cumbria');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CMD','Camden');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CMN','Carmarthenshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CON','Cornwall');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'COV','Coventry');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CRF','Cardiff');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CRY','Croydon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CSR','Castlereagh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'CWY','Conwy');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DAL','Darlington');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DBY','Derbyshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DEN','Denbighshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DER','Derby');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DEV','Devon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DGN','Dungannon and South Tyrone');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DGY','Dumfries and Galloway');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DNC','Doncaster');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DND','Dundee');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DOR','Dorset');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DOW','Down');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DRY','Derry');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DUD','Dudley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'DUR','Durham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'EAL','Ealing');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'EAY','East Ayrshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'EDH','Edinburgh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'EDU','East Dunbartonshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ELN','East Lothian');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ELS','Eilean Siar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ENF','Enfield');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ERW','East Renfrewshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ERY','East Riding of Yorkshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ESS','Essex');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ESX','East Sussex');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'FAL','Falkirk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'FER','Fermanagh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'FIF','Fife');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'FLN','Flintshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'GAT','Gateshead');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'GLG','Glasgow');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'GLS','Gloucestershire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'GRE','Greenwich');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'GSY','Guernsey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'GWN','Gwynedd');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HAL','Halton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HAM','Hampshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HAV','Havering');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HCK','Hackney');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HEF','Herefordshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HIL','Hillingdon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HLD','Highland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HMF','Hammersmith and Fulham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HNS','Hounslow');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HPL','Hartlepool');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HRT','Hertfordshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HRW','Harrow');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'HRY','Haringey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'IOS','Isles of Scilly');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'IOW','Isle of Wight');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ISL','Islington');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'IVC','Inverclyde');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'JSY','Jersey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'KEC','Kensington and Chelsea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'KEN','Kent');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'KHL','Kingston upon Hull');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'KIR','Kirklees');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'KTT','Kingston upon Thames');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'KWL','Knowsley');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LAN','Lancashire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LBH','Lambeth');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LCE','Leicester');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LDS','Leeds');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LEC','Leicestershire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LEW','Lewisham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LIN','Lincolnshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LIV','Liverpool');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LMV','Limavady');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LND','London');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LRN','Larne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LSB','Lisburn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'LUT','Luton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MAN','Manchester');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MDB','Middlesbrough');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MDW','Medway');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MFT','Magherafelt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MIK','Milton Keynes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MLN','Midlothian');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MON','Monmouthshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MRT','Merton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MRY','Moray');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MTY','Merthyr Tydfil');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'MYL','Moyle');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NAY','North Ayrshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NBL','Northumberland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NDN','North Down');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NEL','North East Lincolnshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NET','Newcastle upon Tyne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NFK','Norfolk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NGM','Nottingham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NLK','North Lanarkshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NLN','North Lincolnshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NSM','North Somerset');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NTA','Newtownabbey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NTH','Northamptonshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NTL','Neath Port Talbot');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NTT','Nottinghamshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NTY','North Tyneside');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NWM','Newham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NWP','Newport');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NYK','North Yorkshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'NYM','Newry and Mourne');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'OLD','Oldham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'OMH','Omagh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ORK','Orkney Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'OXF','Oxfordshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'PEM','Pembrokeshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'PKN','Perth and Kinross');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'PLY','Plymouth');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'POL','Poole');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'POR','Portsmouth');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'POW','Powys');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'PTE','Peterborough');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RCC','Redcar and Cleveland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RCH','Rochdale');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RCT','Rhondda Cynon Taf');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RDB','Redbridge');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RDG','Reading');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RFW','Renfrewshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RIC','Richmond upon Thames');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ROT','Rotherham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'RUT','Rutland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SAW','Sandwell');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SAY','South Ayrshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SCB','Scottish Borders');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SFK','Suffolk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SFT','Sefton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SGC','South Gloucestershire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SHF','Sheffield');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SHN','Saint Helens');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SHR','Shropshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SKP','Stockport');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SLF','Salford');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SLG','Slough');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SLK','South Lanarkshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SND','Sunderland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SOL','Solihull');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SOM','Somerset');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SOS','Southend-on-Sea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SRY','Surrey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STB','Strabane');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STE','Stoke-on-Trent');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STG','Stirling');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STH','Southampton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STN','Sutton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STS','Staffordshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STT','Stockton-on-Tees');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'STY','South Tyneside');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SWA','Swansea');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SWD','Swindon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'SWK','Southwark');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'TAM','Tameside');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'TFW','Telford and Wrekin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'THR','Thurrock');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'TOB','Torbay');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'TOF','Torfaen');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'TRF','Trafford');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'TWH','Tower Hamlets');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'VGL','Vale of Glamorgan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WAR','Warwickshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WBK','West Berkshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WDU','West Dunbartonshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WFT','Waltham Forest');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WGN','Wigan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WIL','Wiltshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WKF','Wakefield');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WLL','Walsall');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WLN','West Lothian');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WLV','Wolverhampton');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WNM','Windsor and Maidenhead');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WOK','Wokingham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WOR','Worcestershire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WRL','Wirral');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WRT','Warrington');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WRX','Wrexham');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WSM','Westminster');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'WSX','West Sussex');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'YOR','York');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (222,'ZET','Shetland Islands');

INSERT INTO kuu_countries VALUES (223,'United States of America','US','USA',E':name\n:street_address\n:city :state_code :postcode\n:country');

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'AK','Alaska');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'AL','Alabama');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'AS','American Samoa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'AR','Arkansas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'AZ','Arizona');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'CA','California');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'CO','Colorado');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'CT','Connecticut');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'DC','District of Columbia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'DE','Delaware');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'FL','Florida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'GA','Georgia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'GU','Guam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'HI','Hawaii');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'IA','Iowa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'ID','Idaho');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'IL','Illinois');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'IN','Indiana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'KS','Kansas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'KY','Kentucky');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'LA','Louisiana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MA','Massachusetts');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MD','Maryland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'ME','Maine');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MI','Michigan');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MN','Minnesota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MO','Missouri');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MS','Mississippi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MT','Montana');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NC','North Carolina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'ND','North Dakota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NE','Nebraska');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NH','New Hampshire');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NJ','New Jersey');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NM','New Mexico');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NV','Nevada');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'NY','New York');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'MP','Northern Mariana Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'OH','Ohio');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'OK','Oklahoma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'OR','Oregon');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'PA','Pennsylvania');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'PR','Puerto Rico');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'RI','Rhode Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'SC','South Carolina');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'SD','South Dakota');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'TN','Tennessee');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'TX','Texas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'UM','U.S. Minor Outlying Islands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'UT','Utah');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'VA','Virginia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'VI','Virgin Islands of the U.S.');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'VT','Vermont');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'WA','Washington');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'WI','Wisconsin');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'WV','West Virginia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (223,'WY','Wyoming');

INSERT INTO kuu_countries VALUES (224,'United States Minor Outlying Islands','UM','UMI',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'BI','Baker Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'HI','Howland Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'JI','Jarvis Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'JA','Johnston Atoll');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'KR','Kingman Reef');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'MA','Midway Atoll');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'NI','Navassa Island');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'PA','Palmyra Atoll');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (224,'WI','Wake Island');

INSERT INTO kuu_countries VALUES (225,'Uruguay','UY','URY',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'AR','Artigas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'CA','Canelones');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'CL','Cerro Largo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'CO','Colonia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'DU','Durazno');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'FD','Florida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'FS','Flores');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'LA','Lavalleja');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'MA','Maldonado');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'MO','Montevideo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'PA','Paysandu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'RN','Río Negro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'RO','Rocha');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'RV','Rivera');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'SA','Salto');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'SJ','San José');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'SO','Soriano');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'TA','Tacuarembó');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (225,'TT','Treinta y Tres');

INSERT INTO kuu_countries VALUES (226,'Uzbekistan','UZ','UZB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'AN','Andijon viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'BU','Buxoro viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'FA','Farg''ona viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'JI','Jizzax viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'NG','Namangan viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'NW','Navoiy viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'QA','Qashqadaryo viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'QR','Qoraqalpog''iston Respublikasi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'SA','Samarqand viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'SI','Sirdaryo viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'SU','Surxondaryo viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'TK','Toshkent');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'TO','Toshkent viloyati');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (226,'XO','Xorazm viloyati');

INSERT INTO kuu_countries VALUES (227,'Vanuatu','VU','VUT',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (227,'MAP','Malampa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (227,'PAM','Pénama');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (227,'SAM','Sanma');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (227,'SEE','Shéfa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (227,'TAE','Taféa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (227,'TOB','Torba');

INSERT INTO kuu_countries VALUES (228,'Vatican City State (Holy See)','VA','VAT',null);

INSERT INTO kuu_countries VALUES (229,'Venezuela','VE','VEN',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'A','Distrito Capital');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'B','Anzoátegui');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'C','Apure');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'D','Aragua');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'E','Barinas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'F','Bolívar');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'G','Carabobo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'H','Cojedes');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'I','Falcón');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'J','Guárico');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'K','Lara');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'L','Mérida');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'M','Miranda');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'N','Monagas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'O','Nueva Esparta');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'P','Portuguesa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'R','Sucre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'S','Tachira');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'T','Trujillo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'U','Yaracuy');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'V','Zulia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'W','Capital Dependencia');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'X','Vargas');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'Y','Delta Amacuro');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (229,'Z','Amazonas');

INSERT INTO kuu_countries VALUES (230,'Vietnam','VN','VNM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'01','Lai Châu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'02','Lào Cai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'03','Hà Giang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'04','Cao Bằng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'05','Sơn La');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'06','Yên Bái');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'07','Tuyên Quang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'09','Lạng Sơn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'13','Quảng Ninh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'14','Hòa Bình');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'15','Hà Tây');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'18','Ninh Bình');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'20','Thái Bình');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'21','Thanh Hóa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'22','Nghệ An');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'23','Hà Tĩnh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'24','Quảng Bình');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'25','Quảng Trị');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'26','Thừa Thiên-Huế');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'27','Quảng Nam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'28','Kon Tum');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'29','Quảng Ngãi');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'30','Gia Lai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'31','Bình Định');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'32','Phú Yên');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'33','Đắk Lắk');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'34','Khánh Hòa');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'35','Lâm Đồng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'36','Ninh Thuận');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'37','Tây Ninh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'39','Đồng Nai');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'40','Bình Thuận');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'41','Long An');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'43','Bà Rịa-Vũng Tàu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'44','An Giang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'45','Đồng Tháp');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'46','Tiền Giang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'47','Kiên Giang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'48','Cần Thơ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'49','Vĩnh Long');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'50','Bến Tre');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'51','Trà Vinh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'52','Sóc Trăng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'53','Bắc Kạn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'54','Bắc Giang');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'55','Bạc Liêu');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'56','Bắc Ninh');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'57','Bình Dương');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'58','Bình Phước');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'59','Cà Mau');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'60','Đà Nẵng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'61','Hải Dương');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'62','Hải Phòng');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'63','Hà Nam');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'64','Hà Nội');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'65','Sài Gòn');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'66','Hưng Yên');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'67','Nam Định');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'68','Phú Thọ');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'69','Thái Nguyên');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'70','Vĩnh Phúc');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'71','Điện Biên');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'72','Đắk Nông');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (230,'73','Hậu Giang');

INSERT INTO kuu_countries VALUES (231,'Virgin Islands (British)','VG','VGB',null);
INSERT INTO kuu_countries VALUES (232,'Virgin Islands (U.S.)','VI','VIR',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (232,'C','Saint Croix');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (232,'J','Saint John');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (232,'T','Saint Thomas');

INSERT INTO kuu_countries VALUES (233,'Wallis and Futuna Islands','WF','WLF',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (233,'A','Alo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (233,'S','Sigave');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (233,'W','Wallis');

INSERT INTO kuu_countries VALUES (234,'Western Sahara','EH','ESH',null);
INSERT INTO kuu_countries VALUES (235,'Yemen','YE','YEM',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'AB','أبين‎');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'AD','عدن');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'AM','عمران');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'BA','البيضاء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'DA','الضالع');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'DH','ذمار');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'HD','حضرموت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'HJ','حجة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'HU','الحديدة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'IB','إب');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'JA','الجوف');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'LA','لحج');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'MA','مأرب');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'MR','المهرة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'MW','المحويت');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'SD','صعدة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'SN','صنعاء');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'SH','شبوة');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (235,'TA','تعز');

INSERT INTO kuu_countries VALUES (236,'Yugoslavia','YU','YUG',null);
INSERT INTO kuu_countries VALUES (237,'Zaire','ZR','ZAR',null);

INSERT INTO kuu_countries VALUES (238,'Zambia','ZM','ZMB',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'01','Western');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'02','Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'03','Eastern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'04','Luapula');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'05','Northern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'06','North-Western');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'07','Southern');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'08','Copperbelt');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (238,'09','Lusaka');

INSERT INTO kuu_countries VALUES (239,'Zimbabwe','ZW','ZWE',null);

INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MA','Manicaland');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MC','Mashonaland Central');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'ME','Mashonaland East');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MI','Midlands');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MN','Matabeleland North');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MS','Matabeleland South');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MV','Masvingo');
INSERT INTO kuu_zones (zone_country_id, zone_code, zone_name) VALUES (239,'MW','Mashonaland West');

ALTER SEQUENCE kuu_countries_countries_id_seq RESTART 240;

-- Regular expression patterns from http://www.creditcardcode.net
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'American Express',E'/^(34|37)\\d{13}$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Diners Club',E'/^(30|36|38)\\d{12}$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'JCB',E'/^((2131|1800)\\d{11}|3[0135]\\d{14})$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'MasterCard',E'/^5[1-5]\\d{14}$/','1','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Visa',E'/^4\\d{12}(\\d{3})?$/','1','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Discover Card',E'/^6011\\d{12}$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Solo',E'/^(63|67)\\d{14}(\\d{2,3})?$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Switch',E'/^(49|56|63|67)\\d{14}(\\d{2,3})?$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Australian Bankcard',E'/^5610\\d{12}$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'enRoute',E'/^(2014|2149)\\d{11}$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Laser',E'/^6304\\d{12}(\\d{2,3})?$/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Maestro','/^(50|56|57|58|6)/','0','0');
INSERT INTO kuu_credit_cards VALUES (DEFAULT,'Saferpay Test Card','/^9451123100000004$/','0','0');

INSERT INTO kuu_currencies VALUES (DEFAULT,'US Dollar','USD','$',null,'2','1.0000', now());
INSERT INTO kuu_currencies VALUES (DEFAULT,'Euro','EUR','€',null,'2','1.2076', now());
INSERT INTO kuu_currencies VALUES (DEFAULT,'British Pounds','GBP','£',null,'2','1.7587', now());

INSERT INTO kuu_languages VALUES (DEFAULT,'English','en_US','en_US.UTF-8,en_US,english','utf-8','%m/%d/%Y','%A %d %B, %Y','%H:%M:%S','ltr',1,'.',',',0,1);

INSERT INTO kuu_orders_status VALUES ( '1', '1', 'Pending');
INSERT INTO kuu_orders_status VALUES ( '2', '1', 'Processing');
INSERT INTO kuu_orders_status VALUES ( '3', '1', 'Delivered');
INSERT INTO kuu_orders_status VALUES ( '4', '1', 'Preparing');

INSERT INTO kuu_orders_transactions_status VALUES ( '1', '1', 'Authorize');
INSERT INTO kuu_orders_transactions_status VALUES ( '2', '1', 'Cancel');
INSERT INTO kuu_orders_transactions_status VALUES ( '3', '1', 'Approve');
INSERT INTO kuu_orders_transactions_status VALUES ( '4', '1', 'Inquiry');

INSERT INTO kuu_product_types values (DEFAULT, 'Shippable');
INSERT INTO kuu_product_types_assignments values (DEFAULT, 1, 'PerformOrder', 'RequireShipping', 100);
INSERT INTO kuu_product_types_assignments values (DEFAULT, 1, 'PerformOrder', 'RequireBilling', 200);

INSERT INTO kuu_products_images_groups values (1, 1, 'Originals', 'originals', 0, 0, 0);
INSERT INTO kuu_products_images_groups values (2, 1, 'Thumbnails', 'thumbnails', 100, 80, 0);
INSERT INTO kuu_products_images_groups values (3, 1, 'Product Information Page', 'product_info', 188, 150, 0);
INSERT INTO kuu_products_images_groups values (4, 1, 'Large', 'large', 375, 300, 0);
INSERT INTO kuu_products_images_groups values (5, 1, 'Mini', 'mini', 50, 40, 0);

INSERT INTO kuu_tax_class VALUES (DEFAULT, 'Taxable Goods', 'The following types of products are included non-food, services, etc', now(), now());

-- USA/Florida
INSERT INTO kuu_tax_rates VALUES (DEFAULT, 1, 1, 1, 7.0, 'FL TAX 7.0%', now(), now());
INSERT INTO kuu_geo_zones (geo_zone_id,geo_zone_name,geo_zone_description,date_added) VALUES (DEFAULT,'Florida','Florida local sales tax zone',now());
INSERT INTO kuu_zones_to_geo_zones (association_id,zone_country_id,zone_id,geo_zone_id,date_added) VALUES (DEFAULT,223,4031,1,now());

-- Templates

INSERT INTO kuu_templates VALUES (DEFAULT, 'Kuuzu Online Store', 'kuuzu', 'Kuuzu', 'https://kuuzu.org', 'XHTML 1.0 Transitional', 1, 'Screen');

INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Best Sellers', 'BestSellers', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Categories', 'Categories', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Currencies', 'Currencies', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Information', 'Information', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Languages', 'Languages', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Manufacturer Info', 'ManufacturerInfo', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Manufacturers', 'Manufacturers', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Order History', 'OrderHistory', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Product Notifications', 'ProductNotifications', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Reviews', 'Reviews', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Search', 'Search', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Shopping Cart', 'ShoppingCart', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Specials', 'Specials', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Tell a Friend', 'TellAFriend', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'What''s New', 'WhatsNew', 'Kuuzu', 'https://kuuzu.org', 'Box');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'New Products', 'NewProducts', 'Kuuzu', 'https://kuuzu.org', 'Content');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Upcoming Products', 'UpcomingProducts', 'Kuuzu', 'https://kuuzu.org', 'Content');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Recently Visited', 'RecentlyVisited', 'Kuuzu', 'https://kuuzu.org', 'Content');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Also Purchased Products', 'AlsoPurchasedProducts', 'Kuuzu', 'https://kuuzu.org', 'Content');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Date Available', 'DateAvailable', 'Kuuzu', 'https://kuuzu.org', 'ProductAttribute');
INSERT INTO kuu_templates_boxes VALUES (DEFAULT, 'Manufacturers', 'Manufacturers', 'Kuuzu', 'https://kuuzu.org', 'ProductAttribute');

INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 2, 1, '*', 'left', 100, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 7, 1, '*', 'left', 200, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 15, 1, '*', 'left', 300, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 11, 1, '*', 'left', 400, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 4, 1, '*', 'left', 500, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 12, 1, '*', 'right', 100, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 6, 1, 'Products/main', 'right', 200, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 8, 1, '*', 'right', 300, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 1, 1, '*', 'right', 400, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 9, 1, 'Products/main', 'right', 500, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 14, 1, 'Products/main','right', 600, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 13, 1, '*', 'right', 700, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 10, 1, '*', 'right', 800, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 5, 1, '*', 'right', 900, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 3, 1, '*', 'right', 1000, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 16, 1, 'Index/category_listing', 'after', 400, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 16, 1, 'Index/main','after', 400, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 17, 1, 'Index/main','after', 450, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 18, 1, '*', 'after', 500, 0);
INSERT INTO kuu_templates_boxes_to_pages VALUES (DEFAULT, 19, 1, 'Products/main', 'after', 100, 0);

INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimum List Size', 'BOX_BEST_SELLERS_MIN_LIST', '3', 'Minimum amount of products that must be shown in the listing', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum List Size', 'BOX_BEST_SELLERS_MAX_LIST', '10', 'Maximum amount of products to show in the listing', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_BEST_SELLERS_CACHE', '60', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Show Product Count', 'BOX_CATEGORIES_SHOW_PRODUCT_COUNT', '1', 'Show the amount of products each category has', '6', '0', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Manufacturers List Size', 'BOX_MANUFACTURERS_LIST_SIZE', '1', 'The size of the manufacturers pull down menu listing.', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum List Size', 'BOX_ORDER_HISTORY_MAX_LIST', '5', 'Maximum amount of products to show in the listing', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random Review Selection', 'BOX_REVIEWS_RANDOM_SELECT', '10', 'Select a random review from this amount of the newest reviews available', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_REVIEWS_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random Product Specials Selection', 'BOX_SPECIALS_RANDOM_SELECT', '10', 'Select a random product on special from this amount of the newest products on specials available', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_SPECIALS_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random New Product Selection', 'BOX_WHATS_NEW_RANDOM_SELECT', '10', 'Select a random new product from this amount of the newest products available', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_WHATS_NEW_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum Entries To Display', 'MODULE_CONTENT_NEW_PRODUCTS_MAX_DISPLAY', '9', 'Maximum number of new products to display', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'MODULE_CONTENT_NEW_PRODUCTS_CACHE', '60', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimum Entries To Display', 'MODULE_CONTENT_ALSO_PURCHASED_MIN_DISPLAY', '1', 'Minimum number of also purchased products to display', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum Entries To Display', 'MODULE_CONTENT_ALSO_PURCHASED_MAX_DISPLAY', '6', 'Maximum number of also purchased products to display', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'MODULE_CONTENT_ALSO_PURCHASED_PRODUCTS_CACHE', '60', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum Entries To Display', 'MODULE_CONTENT_UPCOMING_PRODUCTS_MAX_DISPLAY', '10', 'Maximum number of upcoming products to display', '6', '0', now());
INSERT INTO kuu_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'MODULE_CONTENT_UPCOMING_PRODUCTS_CACHE', '1440', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now());

-- Weight Classes

INSERT INTO kuu_weight_classes VALUES (1, 'g', 1, 'Gram(s)');
INSERT INTO kuu_weight_classes VALUES (2, 'kg', 1, 'Kilogram(s)');
INSERT INTO kuu_weight_classes VALUES (3, 'oz', 1, 'Ounce(s)');
INSERT INTO kuu_weight_classes VALUES (4, 'lb', 1, 'Pound(s)');

INSERT INTO kuu_weight_classes_rules VALUES (1, 2, '0.0010');
INSERT INTO kuu_weight_classes_rules VALUES (1, 3, '0.0352');
INSERT INTO kuu_weight_classes_rules VALUES (1, 4, '0.0022');
INSERT INTO kuu_weight_classes_rules VALUES (2, 1, '1000.0000');
INSERT INTO kuu_weight_classes_rules VALUES (2, 3, '35.2739');
INSERT INTO kuu_weight_classes_rules VALUES (2, 4, '2.2046');
INSERT INTO kuu_weight_classes_rules VALUES (3, 1, '28.3495');
INSERT INTO kuu_weight_classes_rules VALUES (3, 2, '0.0283');
INSERT INTO kuu_weight_classes_rules VALUES (3, 4, '0.0625');
INSERT INTO kuu_weight_classes_rules VALUES (4, 1, '453.5923');
INSERT INTO kuu_weight_classes_rules VALUES (4, 2, '0.4535');
INSERT INTO kuu_weight_classes_rules VALUES (4, 3, '16.0000');

-- Foreign key relationships

INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'address_book', 'customers', 'customers_id', 'customers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'address_book', 'countries', 'entry_country_id', 'countries_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'address_book', 'zones', 'entry_zone_id', 'zone_id', 'cascade', 'set_DEFAULT');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'administrators_access', 'administrators', 'administrators_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'audit_log_rows', 'audit_log', 'audit_log_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'banners_history', 'banners', 'banners_id', 'banners_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'categories', 'categories', 'parent_id', 'categories_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'categories_description', 'categories', 'categories_id', 'categories_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'categories_description', 'languages', 'language_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'configuration', 'configuration_group', 'configuration_group_id', 'configuration_group_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'customers', 'address_book', 'customers_default_address_id', 'address_book_id', 'cascade', 'set_null');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'languages', 'currencies', 'currencies_id', 'currencies_id', 'cascade', 'restrict');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'languages_definitions', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'manufacturers_info', 'manufacturers', 'manufacturers_id', 'manufacturers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'manufacturers_info', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'newsletters_log', 'newsletters', 'newsletters_id', 'newsletters_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders', 'orders_status', 'orders_status', 'orders_status_id', 'cascade', 'restrict');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_products', 'orders', 'orders_id', 'orders_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_products_download', 'orders', 'orders_id', 'orders_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_products_variants', 'orders', 'orders_id', 'orders_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_status', 'languages', 'language_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_status_history', 'orders', 'orders_id', 'orders_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_status_history', 'orders_status', 'orders_status_id', 'orders_status_id', 'cascade', 'restrict');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_total', 'orders', 'orders_id', 'orders_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_transactions_history', 'orders', 'orders_id', 'orders_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'orders_transactions_status', 'languages', 'language_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'product_attributes', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'product_attributes', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'product_types_assignments', 'product_types', 'types_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products', 'products', 'parent_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products', 'weight_classes', 'products_weight_class', 'weight_class_id', 'cascade', 'restrict');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products', 'tax_class', 'products_tax_class_id', 'tax_class_id', 'cascade', 'set_null');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products', 'manufacturers', 'manufacturers_id', 'manufacturers_id', 'cascade', 'set_null');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products', 'product_types', 'products_types_id', 'id', 'cascade', 'set_null');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_description', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_description', 'languages', 'language_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_images', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_images_groups', 'languages', 'language_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_notifications', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_notifications', 'customers', 'customers_id', 'customers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_to_categories', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_to_categories', 'categories', 'categories_id', 'categories_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_variants', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_variants', 'products_variants_values', 'products_variants_values_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_variants_groups', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_variants_values', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'products_variants_values', 'products_variants_groups', 'products_variants_groups_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'reviews', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'reviews', 'customers', 'customers_id', 'customers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'reviews', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'shipping_availability', 'languages', 'languages_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'shopping_carts', 'customers', 'customers_id', 'customers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'shopping_carts', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'shopping_carts_custom_variants_values', 'customers', 'customers_id', 'customers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'shopping_carts_custom_variants_values', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'shopping_carts_custom_variants_values', 'products_variants_values', 'products_variants_values_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'specials', 'products', 'products_id', 'products_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'tax_rates', 'geo_zones', 'tax_zone_id', 'geo_zone_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'tax_rates', 'tax_class', 'tax_class_id', 'tax_class_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'templates_boxes_to_pages', 'templates_boxes', 'templates_boxes_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'templates_boxes_to_pages', 'templates', 'templates_id', 'id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'weight_classes', 'languages', 'language_id', 'languages_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'weight_classes_rules', 'weight_classes', 'weight_class_from_id', 'weight_class_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'weight_classes_rules', 'weight_classes', 'weight_class_to_id', 'weight_class_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'whos_online', 'customers', 'customer_id', 'customers_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'zones', 'countries', 'zone_country_id', 'countries_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'zones_to_geo_zones', 'countries', 'zone_country_id', 'countries_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'zones_to_geo_zones', 'zones', 'zone_id', 'zone_id', 'cascade', 'cascade');
INSERT INTO kuu_fk_relationships VALUES (DEFAULT, 'zones_to_geo_zones', 'geo_zones', 'geo_zone_id', 'geo_zone_id', 'cascade', 'cascade');
