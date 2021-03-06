-- Kuuzu Cart
--
-- @copyright Copyright (c) 2011 osCommerce; http://www.oscommerce.com
-- @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
--
-- @copyright Copyright (c) 2018 Kuuzu; https://kuuzu.org
-- @license MIT License; https://kuuzu.org/mitlicense.txt

INSERT INTO kuu_products_variants_groups VALUES (DEFAULT, 1, 'Size', 1, 'PullDownMenu');
INSERT INTO kuu_products_variants_groups VALUES (DEFAULT, 1, 'Colour', 2, 'PullDownMenu');
INSERT INTO kuu_products_variants_groups VALUES (DEFAULT, 1, 'Material', 3, 'RadioButton');
INSERT INTO kuu_products_variants_groups VALUES (DEFAULT, 1, 'Text', 4, 'TextField');

INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 1, 'Small', 1);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 1, 'Medium', 2);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 1, 'Large', 3);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 2, 'White', 1);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 2, 'Black', 2);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 3, 'Soft', 1);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 3, 'Hard', 2);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 4, 'Front', 1);
INSERT INTO kuu_products_variants_values VALUES (DEFAULT, 1, 4, 'Back', 2);

INSERT INTO kuu_categories VALUES (DEFAULT, 'books.gif', null, 1, now(), null);
INSERT INTO kuu_categories VALUES (DEFAULT, 'php.gif', 1, 1, now(), null);
INSERT INTO kuu_categories VALUES (DEFAULT, null, null, 2, now(), null);
INSERT INTO kuu_categories VALUES (DEFAULT, null, null, 3, now(), null);

INSERT INTO kuu_categories_description VALUES (1, 1, 'Books');
INSERT INTO kuu_categories_description VALUES (2, 1, 'PHP');
INSERT INTO kuu_categories_description VALUES (3, 1, 'Gadgets');
INSERT INTO kuu_categories_description VALUES (4, 1, 'Merchandise');

INSERT INTO kuu_manufacturers VALUES (DEFAULT, 'Apress', 'apress.gif', now(), null);
INSERT INTO kuu_manufacturers VALUES (DEFAULT, 'Dymo', 'dymo.gif', now(), null);

INSERT INTO kuu_manufacturers_info VALUES (1, 1, 'http://www.apress.com', 0, null);
INSERT INTO kuu_manufacturers_info VALUES (2, 1, 'http://www.dymo.com', 0, null);

INSERT INTO kuu_products VALUES (DEFAULT, null, 10, 44.99, '1590595084', now(), now(), 1, 2, 1, 1, 1, 1, 0, 0);
INSERT INTO kuu_products VALUES (DEFAULT, null, 0, 0, null, now(), now(), 0, null, 1, null, 1, 2, 0, 1);
INSERT INTO kuu_products VALUES (DEFAULT, 2, 50, 139, 'DYMO400B', now(), null, 1, 2, 1, 1, 1, 2, 0, 0);
INSERT INTO kuu_products VALUES (DEFAULT, 2, 20, 139, 'DYMO400W', now(), null, 1, 2, 1, 1, 1, 2, 0, 0);
INSERT INTO kuu_products VALUES (DEFAULT, null, 0, 0, null, now(), now(), 0, null, 1, null, 1, null, 0, 1);
INSERT INTO kuu_products VALUES (DEFAULT, 5, 20, 20, 'KUUSHIRTM', now(), null, 1, 2, 1, 1, 1, null, 0, 0);
INSERT INTO kuu_products VALUES (DEFAULT, 5, 20, 25, 'KUUSHIRTL', now(), null, 1, 2, 1, 1, 1, null, 0, 0);

INSERT INTO kuu_products_description VALUES (1, 1, 'Pro PHP Security', '<p><i>Pro PHP Security</i> is one of the first books devoted solely to PHP security. It will serve as your complete guide for taking defensive and proactive security measures within your PHP applications. (And the methods discussed are compatible with PHP versions 3, 4, and 5.)</p><p>The knowledge you''ll gain from this comprehensive guide will help you prevent attackers from potentially disrupting site operation or destroying data. And you''ll learn about various security measures, for example, creating and deploying "captchas," validating e-mail, fending off SQL injection attacks, and preventing cross-site scripting attempts.</p><h3>Author Information</h3><h4>Chris Snyder</h4><p>Chris Snyder is a software engineer at Fund for the City of New York, where he helps develop next-generation websites and services for nonprofit organizations. He is a member of the Executive Board of New York PHP, and has been looking for new ways to build scriptable, linked, multimedia content since he saw his first Hypercard stack in 1988.</p></p><p align="justify"><h4>Michael Southwell</h4><p>Michael Southwell is a retired English professor who has been developing websites for more than 10 years in the small business, nonprofit, and educational areas, with special interest in problems of accessibility. He has authored and co-authored 8 books and numerous articles about writing, writing and computers, and writing education. He is a member of the Executive Board of New York PHP, and a Zend Certified Engineer.</p>', 'pro_php_security', 'pro php security book apress', null, 0);
INSERT INTO kuu_products_description VALUES (2, 1, 'LabelWriter 400 Turbo', '<p>Compact, lightning-quick and easy to use – this LabelWriter is the fastest PC-and-Mac compatible label printer in its class. A customer favorite, 400 Turbo prints high-resolution labels for envelopes, packages, files, folders, media, name badges and more – directly from Microsoft® Word, WordPerfect®, Outlook®, QuickBooks®, ACT!® and other popular software.</p><h4>Features & Benefits</h4><ul><li>Eliminates the hassle of printing labels with a standard office printer.</li><li>Direct thermal printing means you never change a ribbon, toner or ink cartridges. The only supplies you ever need are the labels.</li><li>Super fast print speed. About 1 second per label, 55 labels per minute. Very quiet.</li></ul>', 'labelwriter_400_turbo', 'label printer', 'http://global.dymo.com/enUS/Products/LabelWriter_400_Turbo.html', 0);
INSERT INTO kuu_products_description VALUES (5, 1, 'Kuuzu T-Shirt', '<p>Kuuzu t-shirt made from 100% cotton.</p>', 'kuuzu-tshirt', 'tshirt', null, 0);

INSERT INTO kuu_products_variants VALUES (3, 5, 1);
INSERT INTO kuu_products_variants VALUES (4, 4, 0);
INSERT INTO kuu_products_variants VALUES (6, 2, 1);
INSERT INTO kuu_products_variants VALUES (6, 8, 1);
INSERT INTO kuu_products_variants VALUES (7, 3, 0);
INSERT INTO kuu_products_variants VALUES (7, 8, 0);

INSERT INTO kuu_products_to_categories VALUES (1, 2);
INSERT INTO kuu_products_to_categories VALUES (2, 3);
INSERT INTO kuu_products_to_categories VALUES (5, 4);

INSERT INTO kuu_products_images VALUES (DEFAULT, 1, 'pro_php_security.jpg', 1, 1, now());
INSERT INTO kuu_products_images VALUES (DEFAULT, 2, 'dymo400.png', 1, 1, now());
INSERT INTO kuu_products_images VALUES (DEFAULT, 5, 'front.png', 1, 1, now());
INSERT INTO kuu_products_images VALUES (DEFAULT, 5, 'back.png', 0, 2, now());

INSERT INTO kuu_product_attributes VALUES (21, 1, 1, 1);
INSERT INTO kuu_product_attributes VALUES (21, 2, 1, 2);

#INSERT INTO kuu_reviews VALUES (DEFAULT,19,0,'John doe',5,1,'this has to be one of the funniest movies released for 1999!',now(),null,0,1);

INSERT INTO kuu_shipping_availability values (1, 1, 'Ships within 24 hours.', 'ships24hours');

#INSERT INTO kuu_specials VALUES (DEFAULT,3, 39.99, now(), null, null, null, null, '1');
#INSERT INTO kuu_specials VALUES (DEFAULT,5, 30.00, now(), null, null, null, null, '1');
#INSERT INTO kuu_specials VALUES (DEFAULT,6, 30.00, now(), null, null, null, null, '1');
#INSERT INTO kuu_specials VALUES (DEFAULT,16, 29.99, now(), null, null, null, null, '1');
