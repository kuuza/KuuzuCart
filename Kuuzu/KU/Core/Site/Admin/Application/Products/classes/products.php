<?php
/*
  @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com

  @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
*/

  class Kuu_Products_Admin {
    public static function get($id) {
      global $Kuu_Database, $Kuu_Language;

      $Qproducts = $Kuu_Database->query('select p.*, pd.* from :table_products p, :table_products_description pd where p.products_id = :products_id and p.products_id = pd.products_id and pd.language_id = :language_id');
      $Qproducts->bindTable(':table_products', TABLE_PRODUCTS);
      $Qproducts->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
      $Qproducts->bindInt(':products_id', $id);
      $Qproducts->bindInt(':language_id', $Kuu_Language->getID());
      $Qproducts->execute();

      $data = $Qproducts->toArray();

      $variants_array = array();

      if ( $data['has_children'] == '1' ) {
        $Qsubproducts = $Kuu_Database->query('select * from :table_products where parent_id = :parent_id and products_status = :products_status');
        $Qsubproducts->bindTable(':table_products', TABLE_PRODUCTS);
        $Qsubproducts->bindInt(':parent_id', $data['products_id']);
        $Qsubproducts->bindInt(':products_status', 1);
        $Qsubproducts->execute();

        while ( $Qsubproducts->next() ) {
          $variants_array[$Qsubproducts->valueInt('products_id')]['data'] = array('price' => $Qsubproducts->value('products_price'),
                                                                                  'tax_class_id' => $Qsubproducts->valueInt('products_tax_class_id'),
                                                                                  'model' => $Qsubproducts->value('products_model'),
                                                                                  'quantity' => $Qsubproducts->value('products_quantity'),
                                                                                  'weight' => $Qsubproducts->value('products_weight'),
                                                                                  'weight_class_id' => $Qsubproducts->valueInt('products_weight_class'),
                                                                                  'availability_shipping' => 1);

          $Qvariants = $Kuu_Database->query('select pv.default_combo, pvg.id as group_id, pvg.title as group_title, pvg.module, pvv.id as value_id, pvv.title as value_title, pvv.sort_order as value_sort_order from :table_products_variants pv, :table_products_variants_groups pvg, :table_products_variants_values pvv where pv.products_id = :products_id and pv.products_variants_values_id = pvv.id and pvv.languages_id = :languages_id and pvv.products_variants_groups_id = pvg.id and pvg.languages_id = :languages_id order by pvg.sort_order, pvg.title');
          $Qvariants->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
          $Qvariants->bindTable(':table_products_variants_groups', TABLE_PRODUCTS_VARIANTS_GROUPS);
          $Qvariants->bindTable(':table_products_variants_values', TABLE_PRODUCTS_VARIANTS_VALUES);
          $Qvariants->bindInt(':products_id', $Qsubproducts->valueInt('products_id'));
          $Qvariants->bindInt(':languages_id', $Kuu_Language->getID());
          $Qvariants->bindInt(':languages_id', $Kuu_Language->getID());
          $Qvariants->execute();

          while ( $Qvariants->next() ) {
            $variants_array[$Qsubproducts->valueInt('products_id')]['values'][$Qvariants->valueInt('group_id')][$Qvariants->valueInt('value_id')] = array('value_id' => $Qvariants->valueInt('value_id'),
                                                                                                                                                          'group_title' => $Qvariants->value('group_title'),
                                                                                                                                                          'value_title' => $Qvariants->value('value_title'),
                                                                                                                                                          'sort_order' => $Qvariants->value('value_sort_order'),
                                                                                                                                                          'default' => (bool)$Qvariants->valueInt('default_combo'),
                                                                                                                                                          'module' => $Qvariants->value('module'));
          }
        }
      }

      $data['variants'] = $variants_array;

      $Qattributes = $Kuu_Database->query('select id, value from :table_product_attributes where products_id = :products_id and languages_id in (0, :languages_id)');
      $Qattributes->bindTable(':table_product_attributes', TABLE_PRODUCT_ATTRIBUTES);
      $Qattributes->bindInt(':products_id', $id);
      $Qattributes->bindInt(':languages_id', $Kuu_Language->getID());
      $Qattributes->execute();

      $attributes_array = array();

      while ( $Qattributes->next() ) {
        $attributes_array[$Qattributes->valueInt('id')] = $Qattributes->value('value');
      }

      $data['attributes'] = $attributes_array;

      return $data;
    }

    public static function getAll($category_id = null, $pageset = 1) {
      global $Kuu_Database, $Kuu_Language, $Kuu_Currencies;

      if ( !is_numeric($category_id) ) {
        $category_id = 0;
      }

      if ( !is_numeric($pageset) || (floor($pageset) != $pageset) ) {
        $pageset = 1;
      }

      $result = array('entries' => array());

      if ( $category_id > 0 ) {
        $Kuu_CategoryTree = new Kuu_CategoryTree_Admin();
        $Kuu_CategoryTree->setBreadcrumbUsage(false);

        $in_categories = array($category_id);

        foreach ( $Kuu_CategoryTree->getArray($category_id) as $category ) {
          $in_categories[] = $category['id'];
        }

        $Qproducts = $Kuu_Database->query('select SQL_CALC_FOUND_ROWS distinct p.*, pd.products_name from :table_products p, :table_products_description pd, :table_products_to_categories p2c where p.parent_id is null and p.products_id = pd.products_id and pd.language_id = :language_id and p.products_id = p2c.products_id and p2c.categories_id in (:categories_id)');
        $Qproducts->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
        $Qproducts->bindRaw(':categories_id', implode(',', $in_categories));
      } else {
        $Qproducts = $Kuu_Database->query('select SQL_CALC_FOUND_ROWS p.*, pd.products_name from :table_products p, :table_products_description pd where p.parent_id is null and p.products_id = pd.products_id and pd.language_id = :language_id');
      }

      $Qproducts->appendQuery('order by pd.products_name');
      $Qproducts->bindTable(':table_products', TABLE_PRODUCTS);
      $Qproducts->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
      $Qproducts->bindInt(':language_id', $Kuu_Language->getID());

      if ( $pageset !== -1 ) {
        $Qproducts->setBatchLimit($pageset, MAX_DISPLAY_SEARCH_RESULTS);
      }

      $Qproducts->execute();

      while ( $Qproducts->next() ) {
        $price = $Kuu_Currencies->format($Qproducts->value('products_price'));
        $products_status = ($Qproducts->valueInt('products_status') === 1);
        $products_quantity = $Qproducts->valueInt('products_quantity');

        if ( $Qproducts->valueInt('has_children') === 1 ) {
          $Qvariants = $Kuu_Database->query('select min(products_price) as min_price, max(products_price) as max_price, sum(products_quantity) as total_quantity, min(products_status) as products_status from :table_products where parent_id = :parent_id');
          $Qvariants->bindTable(':table_products', TABLE_PRODUCTS);
          $Qvariants->bindInt(':parent_id', $Qproducts->valueInt('products_id'));
          $Qvariants->execute();

          $products_status = ($Qvariants->valueInt('products_status') === 1);
          $products_quantity = '(' . $Qvariants->valueInt('total_quantity') . ')';

          $price = $Kuu_Currencies->format($Qvariants->value('min_price'));

          if ( $Qvariants->value('min_price') != $Qvariants->value('max_price') ) {
            $price .= ' - ' . $Kuu_Currencies->format($Qvariants->value('max_price'));
          }
        }

        $extra_data = array('products_price_formatted' => $price,
                            'products_status' => $products_status,
                            'products_quantity' => $products_quantity);

        $result['entries'][] = array_merge($Qproducts->toArray(), $extra_data);
      }

      $result['total'] = $Qproducts->getBatchSize();

      $Qproducts->freeResult();

      return $result;
    }

    public static function find($search, $category_id = null, $pageset = 1) {
      global $Kuu_Database, $Kuu_Language, $Kuu_Currencies;

      if ( !is_numeric($category_id) ) {
        $category_id = 0;
      }

      if ( !is_numeric($pageset) || (floor($pageset) != $pageset) ) {
        $pageset = 1;
      }

      $result = array('entries' => array());

      if ( $category_id > 0 ) {
        $Kuu_CategoryTree = new Kuu_CategoryTree_Admin();
        $Kuu_CategoryTree->setBreadcrumbUsage(false);

        $in_categories = array($category_id);

        foreach ( $Kuu_CategoryTree->getArray($category_id) as $category ) {
          $in_categories[] = $category['id'];
        }

        $Qproducts = $Kuu_Database->query('select SQL_CALC_FOUND_ROWS distinct p.*, pd.products_name from :table_products p, :table_products_description pd, :table_products_to_categories p2c where p.parent_id is null and p.products_id = pd.products_id and pd.language_id = :language_id and p.products_id = p2c.products_id and p2c.categories_id in (:categories_id)');
        $Qproducts->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
        $Qproducts->bindRaw(':categories_id', implode(',', $in_categories));
      } else {
        $Qproducts = $Kuu_Database->query('select SQL_CALC_FOUND_ROWS p.*, pd.products_name from :table_products p, :table_products_description pd where p.parent_id is null and p.products_id = pd.products_id and pd.language_id = :language_id');
      }

      $Qproducts->appendQuery('and (pd.products_name like :products_name or pd.products_keyword like :products_keyword) order by pd.products_name');
      $Qproducts->bindTable(':table_products', TABLE_PRODUCTS);
      $Qproducts->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
      $Qproducts->bindInt(':language_id', $Kuu_Language->getID());
      $Qproducts->bindValue(':products_name', '%' . $search . '%');
      $Qproducts->bindValue(':products_keyword', '%' . $search . '%');

      if ( $pageset !== -1 ) {
        $Qproducts->setBatchLimit($pageset, MAX_DISPLAY_SEARCH_RESULTS);
      }

      $Qproducts->execute();

      while ( $Qproducts->next() ) {
        $price = $Kuu_Currencies->format($Qproducts->value('products_price'));
        $products_status = ($Qproducts->valueInt('products_status') === 1);
        $products_quantity = $Qproducts->valueInt('products_quantity');

        if ( $Qproducts->valueInt('has_children') === 1 ) {
          $Qvariants = $Kuu_Database->query('select min(products_price) as min_price, max(products_price) as max_price, sum(products_quantity) as total_quantity, min(products_status) as products_status from :table_products where parent_id = :parent_id');
          $Qvariants->bindTable(':table_products', TABLE_PRODUCTS);
          $Qvariants->bindInt(':parent_id', $Qproducts->valueInt('products_id'));
          $Qvariants->execute();

          $products_status = ($Qvariants->valueInt('products_status') === 1);
          $products_quantity = '(' . $Qvariants->valueInt('total_quantity') . ')';

          $price = $Kuu_Currencies->format($Qvariants->value('min_price'));

          if ( $Qvariants->value('min_price') != $Qvariants->value('max_price') ) {
            $price .= '&nbsp;-&nbsp;' . $Kuu_Currencies->format($Qvariants->value('max_price'));
          }
        }

        $extra_data = array('products_price_formatted' => $price,
                            'products_status' => $products_status,
                            'products_quantity' => $products_quantity);

        $result['entries'][] = array_merge($Qproducts->toArray(), $extra_data);
      }

      $result['total'] = $Qproducts->getBatchSize();

      $Qproducts->freeResult();

      return $result;
    }

    public static function save($id = null, $data) {
      global $Kuu_Database, $Kuu_Language, $Kuu_Image;

      $error = false;

      $Kuu_Database->startTransaction();

      if ( is_numeric($id) ) {
        $Qproduct = $Kuu_Database->query('update :table_products set products_quantity = :products_quantity, products_price = :products_price, products_model = :products_model, products_weight = :products_weight, products_weight_class = :products_weight_class, products_status = :products_status, products_tax_class_id = :products_tax_class_id, products_last_modified = now() where products_id = :products_id');
        $Qproduct->bindInt(':products_id', $id);
      } else {
        $Qproduct = $Kuu_Database->query('insert into :table_products (products_quantity, products_price, products_model, products_weight, products_weight_class, products_status, products_tax_class_id, products_date_added) values (:products_quantity, :products_price, :products_model, :products_weight, :products_weight_class, :products_status, :products_tax_class_id, :products_date_added)');
        $Qproduct->bindRaw(':products_date_added', 'now()');
      }

      $Qproduct->bindTable(':table_products', TABLE_PRODUCTS);
      $Qproduct->bindInt(':products_quantity', $data['quantity']);
      $Qproduct->bindFloat(':products_price', $data['price']);
      $Qproduct->bindValue(':products_model', $data['model']);
      $Qproduct->bindFloat(':products_weight', $data['weight']);
      $Qproduct->bindInt(':products_weight_class', $data['weight_class']);
      $Qproduct->bindInt(':products_status', $data['status']);
      $Qproduct->bindInt(':products_tax_class_id', $data['tax_class_id']);
//      $Qproduct->setLogging($_SESSION['module'], $id);
      $Qproduct->execute();

      if ( $Kuu_Database->isError() ) {
        $error = true;
      } else {
        if ( is_numeric($id) ) {
          $products_id = $id;
        } else {
          $products_id = $Kuu_Database->nextID();
        }

        $Qcategories = $Kuu_Database->query('delete from :table_products_to_categories where products_id = :products_id');
        $Qcategories->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
        $Qcategories->bindInt(':products_id', $products_id);
//        $Qcategories->setLogging($_SESSION['module'], $products_id);
        $Qcategories->execute();

        if ( $Kuu_Database->isError() ) {
          $error = true;
        } else {
          if ( isset($data['categories']) && !empty($data['categories']) ) {
            foreach ($data['categories'] as $category_id) {
              $Qp2c = $Kuu_Database->query('insert into :table_products_to_categories (products_id, categories_id) values (:products_id, :categories_id)');
              $Qp2c->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
              $Qp2c->bindInt(':products_id', $products_id);
              $Qp2c->bindInt(':categories_id', $category_id);
//              $Qp2c->setLogging($_SESSION['module'], $products_id);
              $Qp2c->execute();

              if ( $Kuu_Database->isError() ) {
                $error = true;
                break;
              }
            }
          }
        }
      }

      if ( $error === false ) {
        $images = array();

        $products_image = new upload('products_image');
        $products_image->set_extensions(array('gif', 'jpg', 'jpeg', 'png'));

        if ( $products_image->exists() ) {
          $products_image->set_destination(realpath('../images/products/originals'));

          if ( $products_image->parse() && $products_image->save() ) {
            $images[] = $products_image->filename;
          }
        }

        if ( isset($data['localimages']) ) {
          foreach ($data['localimages'] as $image) {
            $image = basename($image);

            if (file_exists('../images/products/_upload/' . $image)) {
              copy('../images/products/_upload/' . $image, '../images/products/originals/' . $image);
              @unlink('../images/products/_upload/' . $image);

              $images[] = $image;
            }
          }
        }

        $default_flag = 1;

        foreach ($images as $image) {
          $Qimage = $Kuu_Database->query('insert into :table_products_images (products_id, image, default_flag, sort_order, date_added) values (:products_id, :image, :default_flag, :sort_order, :date_added)');
          $Qimage->bindTable(':table_products_images', TABLE_PRODUCTS_IMAGES);
          $Qimage->bindInt(':products_id', $products_id);
          $Qimage->bindValue(':image', $image);
          $Qimage->bindInt(':default_flag', $default_flag);
          $Qimage->bindInt(':sort_order', 0);
          $Qimage->bindRaw(':date_added', 'now()');
//          $Qimage->setLogging($_SESSION['module'], $products_id);
          $Qimage->execute();

          if ( $Kuu_Database->isError() ) {
            $error = true;
          } else {
            foreach ($Kuu_Image->getGroups() as $group) {
              if ($group['id'] != '1') {
                $Kuu_Image->resize($image, $group['id']);
              }
            }
          }

          $default_flag = 0;
        }
      }

      if ( $error === false ) {
        foreach ($Kuu_Language->getAll() as $l) {
          if ( is_numeric($id) ) {
            $Qpd = $Kuu_Database->query('update :table_products_description set products_name = :products_name, products_description = :products_description, products_keyword = :products_keyword, products_tags = :products_tags, products_url = :products_url where products_id = :products_id and language_id = :language_id');
          } else {
            $Qpd = $Kuu_Database->query('insert into :table_products_description (products_id, language_id, products_name, products_description, products_keyword, products_tags, products_url) values (:products_id, :language_id, :products_name, :products_description, :products_keyword, :products_tags, :products_url)');
          }

          $Qpd->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
          $Qpd->bindInt(':products_id', $products_id);
          $Qpd->bindInt(':language_id', $l['id']);
          $Qpd->bindValue(':products_name', $data['products_name'][$l['id']]);
          $Qpd->bindValue(':products_description', $data['products_description'][$l['id']]);
          $Qpd->bindValue(':products_keyword', $data['products_keyword'][$l['id']]);
          $Qpd->bindValue(':products_tags', $data['products_tags'][$l['id']]);
          $Qpd->bindValue(':products_url', $data['products_url'][$l['id']]);
//          $Qpd->setLogging($_SESSION['module'], $products_id);
          $Qpd->execute();

          if ( $Kuu_Database->isError() ) {
            $error = true;
            break;
          }
        }
      }

      if ( $error === false ) {
        if ( isset($data['attributes']) && !empty($data['attributes']) ) {
          foreach ( $data['attributes'] as $attributes_id => $value ) {
            if ( is_array($value) ) {
            } elseif ( !empty($value) ) {
              $Qcheck = $Kuu_Database->query('select id from :table_product_attributes where products_id = :products_id and id = :id limit 1');
              $Qcheck->bindTable(':table_product_attributes', TABLE_PRODUCT_ATTRIBUTES);
              $Qcheck->bindInt(':products_id', $products_id);
              $Qcheck->bindInt(':id', $attributes_id);
              $Qcheck->execute();

              if ( $Qcheck->numberOfRows() === 1 ) {
                $Qattribute = $Kuu_Database->query('update :table_product_attributes set value = :value where products_id = :products_id and id = :id');
              } else {
                $Qattribute = $Kuu_Database->query('insert into :table_product_attributes (id, products_id, languages_id, value) values (:id, :products_id, :languages_id, :value)');
                $Qattribute->bindInt(':languages_id', 0);
              }

              $Qattribute->bindTable(':table_product_attributes', TABLE_PRODUCT_ATTRIBUTES);
              $Qattribute->bindValue(':value', $value);
              $Qattribute->bindInt(':products_id', $products_id);
              $Qattribute->bindInt(':id', $attributes_id);
              $Qattribute->execute();

              if ( $Kuu_Database->isError() ) {
                $error = true;
                break;
              }
            }
          }
        }
      }

      if ( $error === false ) {
        $variants_array = array();
        $default_variant_combo = null;

        if ( isset($data['variants_combo']) && !empty($data['variants_combo']) ) {
          foreach ( $data['variants_combo'] as $key => $combos ) {
            if ( isset($data['variants_combo_db'][$key]) ) {
              $Qsubproduct = $Kuu_Database->query('update :table_products set products_quantity = :products_quantity, products_price = :products_price, products_model = :products_model, products_weight = :products_weight, products_weight_class = :products_weight_class, products_status = :products_status, products_tax_class_id = :products_tax_class_id where products_id = :products_id');
              $Qsubproduct->bindInt(':products_id', $data['variants_combo_db'][$key]);
            } else {
              $Qsubproduct = $Kuu_Database->query('insert into :table_products (parent_id, products_quantity, products_price, products_model, products_weight, products_weight_class, products_status, products_tax_class_id, products_date_added) values (:parent_id, :products_quantity, :products_price, :products_model, :products_weight, :products_weight_class, :products_status, :products_tax_class_id, :products_date_added)');
              $Qsubproduct->bindInt(':parent_id', $products_id);
              $Qsubproduct->bindRaw(':products_date_added', 'now()');
            }

            $Qsubproduct->bindTable(':table_products', TABLE_PRODUCTS);
            $Qsubproduct->bindInt(':products_quantity', $data['variants_quantity'][$key]);
            $Qsubproduct->bindFloat(':products_price', $data['variants_price'][$key]);
            $Qsubproduct->bindValue(':products_model', $data['variants_model'][$key]);
            $Qsubproduct->bindFloat(':products_weight', $data['variants_weight'][$key]);
            $Qsubproduct->bindInt(':products_weight_class', $data['variants_weight_class'][$key]);
            $Qsubproduct->bindInt(':products_status', $data['variants_status'][$key]);
            $Qsubproduct->bindInt(':products_tax_class_id', $data['variants_tax_class_id'][$key]);
//            $Qsubproduct->setLogging($_SESSION['module'], $id);
            $Qsubproduct->execute();

            if ( isset($data['variants_combo_db'][$key]) ) {
              $subproduct_id = $data['variants_combo_db'][$key];
            } else {
              $subproduct_id = $Kuu_Database->nextID();
            }

            if ( $data['variants_default_combo'] == $key ) {
              $default_variant_combo = $subproduct_id;
            }

/*
            if ( $Kuu_Database->isError() ) {
              $error = true;
              break;
            }
*/

            $combos_array = explode(';', $combos);

            foreach ( $combos_array as $combo ) {
              list($vgroup, $vvalue) = explode('_', $combo);

              $variants_array[$subproduct_id][] = $vvalue;

              $check_combos_array[] = $vvalue;

              $Qcheck = $Kuu_Database->query('select products_id from :table_products_variants where products_id = :products_id and products_variants_values_id = :products_variants_values_id');
              $Qcheck->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
              $Qcheck->bindInt(':products_id', $subproduct_id);
              $Qcheck->bindInt(':products_variants_values_id', $vvalue);
              $Qcheck->execute();

              if ( $Qcheck->numberOfRows() < 1 ) {
                $Qvcombo = $Kuu_Database->query('insert into :table_products_variants (products_id, products_variants_values_id) values (:products_id, :products_variants_values_id)');
                $Qvcombo->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
                $Qvcombo->bindInt(':products_id', $subproduct_id);
                $Qvcombo->bindInt(':products_variants_values_id', $vvalue);
//                $Qvcombo->setLogging($_SESSION['module'], $products_id);
                $Qvcombo->execute();

                if ( $Kuu_Database->isError() ) {
                  $error = true;
                  break 2;
                }
              }
            }
          }
        }

        if ( $error === false ) {
          if ( empty($variants_array) ) {
            $Qcheck = $Kuu_Database->query('select pv.* from :table_products p, :table_products_variants pv where p.parent_id = :parent_id and p.products_id = pv.products_id');
            $Qcheck->bindTable(':table_products', TABLE_PRODUCTS);
            $Qcheck->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
            $Qcheck->bindInt(':parent_id', $products_id);
            $Qcheck->execute();

            while ( $Qcheck->next() ) {
              $Qdel = $Kuu_Database->query('delete from :table_products_variants where products_id = :products_id');
              $Qdel->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
              $Qdel->bindInt(':products_id', $Qcheck->valueInt('products_id'));
              $Qdel->execute();

              $Qdel = $Kuu_Database->query('delete from :table_products where products_id = :products_id');
              $Qdel->bindTable(':table_products', TABLE_PRODUCTS);
              $Qdel->bindInt(':products_id', $Qcheck->valueInt('products_id'));
              $Qdel->execute();
            }
          } else {
            $Qcheck = $Kuu_Database->query('select pv.* from :table_products p, :table_products_variants pv where p.parent_id = :parent_id and p.products_id = pv.products_id and pv.products_id not in (":products_id")');
            $Qcheck->bindTable(':table_products', TABLE_PRODUCTS);
            $Qcheck->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
            $Qcheck->bindInt(':parent_id', $products_id);
            $Qcheck->bindRaw(':products_id', implode('", "', array_keys($variants_array)));
            $Qcheck->execute();

            while ( $Qcheck->next() ) {
              $Qdel = $Kuu_Database->query('delete from :table_products_variants where products_id = :products_id and products_variants_values_id = :products_variants_values_id');
              $Qdel->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
              $Qdel->bindInt(':products_id', $Qcheck->valueInt('products_id'));
              $Qdel->bindInt(':products_variants_values_id', $Qcheck->valueInt('products_variants_values_id'));
              $Qdel->execute();

              $Qdel = $Kuu_Database->query('delete from :table_products where products_id = :products_id');
              $Qdel->bindTable(':table_products', TABLE_PRODUCTS);
              $Qdel->bindInt(':products_id', $Qcheck->valueInt('products_id'));
              $Qdel->execute();
            }

            foreach ( $variants_array as $key => $values ) {
              $Qdel = $Kuu_Database->query('delete from :table_products_variants where products_id = :products_id and products_variants_values_id not in (":products_variants_values_id")');
              $Qdel->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
              $Qdel->bindInt(':products_id', $key);
              $Qdel->bindRaw(':products_variants_values_id', implode('", "', $values));
              $Qdel->execute();
            }
          }
        }

        $Qupdate = $Kuu_Database->query('update :table_products set has_children = :has_children where products_id = :products_id');
        $Qupdate->bindTable(':table_products', TABLE_PRODUCTS);
        $Qupdate->bindInt(':has_children', (empty($variants_array)) ? 0 : 1);
        $Qupdate->bindInt(':products_id', $products_id);
        $Qupdate->execute();
      }

      if ( $error === false ) {
        $Qupdate = $Kuu_Database->query('update :table_products_variants set default_combo = :default_combo where products_id in (":products_id")');
        $Qupdate->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
        $Qupdate->bindInt(':default_combo', 0);
        $Qupdate->bindRaw(':products_id', implode('", "', array_keys($variants_array)));
        $Qupdate->execute();

        if ( is_numeric($default_variant_combo) ) {
          $Qupdate = $Kuu_Database->query('update :table_products_variants set default_combo = :default_combo where products_id = :products_id');
          $Qupdate->bindTable(':table_products_variants', TABLE_PRODUCTS_VARIANTS);
          $Qupdate->bindInt(':default_combo', 1);
          $Qupdate->bindInt(':products_id', $default_variant_combo);
          $Qupdate->execute();
        }
      }

      if ( $error === false ) {
        $Kuu_Database->commitTransaction();

        Kuu_Cache::clear('categories');
        Kuu_Cache::clear('category_tree');
        Kuu_Cache::clear('also_purchased');

        return true;
      }

      $Kuu_Database->rollbackTransaction();

      return false;
    }

    public static function copy($id, $category_id, $type) {
      global $Kuu_Database;

      $category_array = explode('_', $category_id);

      if ( $type == 'link' ) {
        $Qcheck = $Kuu_Database->query('select count(*) as total from :table_products_to_categories where products_id = :products_id and categories_id = :categories_id');
        $Qcheck->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
        $Qcheck->bindInt(':products_id', $id);
        $Qcheck->bindInt(':categories_id', end($category_array));
        $Qcheck->execute();

        if ( $Qcheck->valueInt('total') < 1 ) {
          $Qcat = $Kuu_Database->query('insert into :table_products_to_categories (products_id, categories_id) values (:products_id, :categories_id)');
          $Qcat->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
          $Qcat->bindInt(':products_id', $id);
          $Qcat->bindInt(':categories_id', end($category_array));
          $Qcat->setLogging($_SESSION['module'], $id);
          $Qcat->execute();

          if ( $Qcat->affectedRows() ) {
            return true;
          }
        }
      } elseif ( $type == 'duplicate' ) {
        $Qproduct = $Kuu_Database->query('select * from :table_products where products_id = :products_id');
        $Qproduct->bindTable(':table_products', TABLE_PRODUCTS);
        $Qproduct->bindInt(':products_id', $id);
        $Qproduct->execute();

        if ( $Qproduct->numberOfRows() === 1 ) {
          $error = false;

          $Kuu_Database->startTransaction();

          $Qnew = $Kuu_Database->query('insert into :table_products (products_quantity, products_price, products_model, products_date_added, products_weight, products_weight_class, products_status, products_tax_class_id, manufacturers_id) values (:products_quantity, :products_price, :products_model, now(), :products_weight, :products_weight_class, 0, :products_tax_class_id, :manufacturers_id)');
          $Qnew->bindTable(':table_products', TABLE_PRODUCTS);
          $Qnew->bindInt(':products_quantity', $Qproduct->valueInt('products_quantity'));
          $Qnew->bindValue(':products_price', $Qproduct->value('products_price'));
          $Qnew->bindValue(':products_model', $Qproduct->value('products_model'));
          $Qnew->bindValue(':products_weight', $Qproduct->value('products_weight'));
          $Qnew->bindInt(':products_weight_class', $Qproduct->valueInt('products_weight_class'));
          $Qnew->bindInt(':products_tax_class_id', $Qproduct->valueInt('products_tax_class_id'));
          $Qnew->bindInt(':manufacturers_id', $Qproduct->valueInt('manufacturers_id'));
          $Qnew->setLogging($_SESSION['module']);
          $Qnew->execute();

          if ( $Qnew->affectedRows() ) {
            $new_product_id = $Kuu_Database->nextID();

            $Qdesc = $Kuu_Database->query('select * from :table_products_description where products_id = :products_id');
            $Qdesc->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
            $Qdesc->bindInt(':products_id', $id);
            $Qdesc->execute();

            while ( $Qdesc->next() ) {
              $Qnewdesc = $Kuu_Database->query('insert into :table_products_description (products_id, language_id, products_name, products_description, products_tags, products_url, products_viewed) values (:products_id, :language_id, :products_name, :products_description, :products_tags, :products_url, 0)');
              $Qnewdesc->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
              $Qnewdesc->bindInt(':products_id', $new_product_id);
              $Qnewdesc->bindInt(':language_id', $Qdesc->valueInt('language_id'));
              $Qnewdesc->bindValue(':products_name', $Qdesc->value('products_name'));
              $Qnewdesc->bindValue(':products_tags', $Qdesc->value('products_tags'));
              $Qnewdesc->bindValue(':products_description', $Qdesc->value('products_description'));
              $Qnewdesc->bindValue(':products_url', $Qdesc->value('products_url'));
              $Qnewdesc->setLogging($_SESSION['module'], $new_product_id);
              $Qnewdesc->execute();

              if ( $Kuu_Database->isError() ) {
                $error = true;
                break;
              }
            }

            if ( $error === false ) {
              $Qp2c = $Kuu_Database->query('insert into :table_products_to_categories (products_id, categories_id) values (:products_id, :categories_id)');
              $Qp2c->bindTable(':table_products_to_categories', TABLE_PRODUCTS_TO_CATEGORIES);
              $Qp2c->bindInt(':products_id', $new_product_id);
              $Qp2c->bindInt(':categories_id', end($category_array));
              $Qp2c->setLogging($_SESSION['module'], $new_product_id);
              $Qp2c->execute();

              if ( $Kuu_Database->isError() ) {
                $error = true;
              }
            }
          } else {
            $error = true;
          }

          if ( $error === false ) {
            $Kuu_Database->commitTransaction();

            Kuu_Cache::clear('categories');
            Kuu_Cache::clear('category_tree');
            Kuu_Cache::clear('also_purchased');

            return true;
          } else {
            $Kuu_Database->rollbackTransaction();
          }
        }
      }

      return false;
    }

    public static function delete($id) {
      global $Kuu_Database, $Kuu_Image;

      $Qim = $Kuu_Database->query('select id from :table_products_images where products_id = :products_id');
      $Qim->bindTable(':table_products_images', TABLE_PRODUCTS_IMAGES);
      $Qim->bindInt(':products_id', $id);
      $Qim->execute();

      while ( $Qim->next() ) {
        $Kuu_Image->delete($Qim->valueInt('id'));
      }

      $Qp = $Kuu_Database->query('delete from :table_products where products_id = :products_id');
      $Qp->bindTable(':table_products', TABLE_PRODUCTS);
      $Qp->bindInt(':products_id', $id);
      $Qp->setLogging($_SESSION['module'], $id);
      $Qp->execute();

      if ( !$Kuu_Database->isError() ) {
        Kuu_Cache::clear('categories');
        Kuu_Cache::clear('category_tree');
        Kuu_Cache::clear('also_purchased');
        Kuu_Cache::clear('box-whats_new');

        return true;
      }

      return false;
    }

    public static function setDateAvailable($id, $data) {
      global $Kuu_Database;

      $Qattribute = $Kuu_Database->query('select pa.id from :table_product_attributes pa, :table_templates_boxes tb where tb.code = :code and tb.modules_group = :modules_group and tb.id = pa.id and products_id = :products_id');
      $Qattribute->bindTable(':table_product_attributes', TABLE_PRODUCT_ATTRIBUTES);
      $Qattribute->bindTable(':table_templates_boxes', TABLE_TEMPLATES_BOXES);
      $Qattribute->bindValue(':code', 'date_available');
      $Qattribute->bindValue(':modules_group', 'product_attributes');
      $Qattribute->bindInt(':products_id', $id);
      $Qattribute->execute();

      $Qupdate = $Kuu_Database->query('update :table_product_attributes set value = :value where id = :id and products_id = :products_id');
      $Qupdate->bindTable(':table_product_attributes', TABLE_PRODUCT_ATTRIBUTES);
      $Qupdate->bindDate(':value', $data['date_available']);
      $Qupdate->bindInt(':id', $Qattribute->valueInt('id'));
      $Qupdate->bindInt(':products_id', $id);
      $Qupdate->setLogging($_SESSION['module'], $id);
      $Qupdate->execute();

      return ( $Qupdate->affectedRows() > 0 );
    }

    public static function getKeywordCount($keyword, $id = null) {
      global $Kuu_Database;

      $Qkeywords = $Kuu_Database->query('select count(*) as total from :table_products_description where products_keyword = :products_keyword');

      if ( is_numeric($id) ) {
        $Qkeywords->appendQuery('and products_id != :products_id');
        $Qkeywords->bindInt(':products_id', $id);
      }

      $Qkeywords->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
      $Qkeywords->bindValue(':products_keyword', $keyword);
      $Qkeywords->execute();

      return $Qkeywords->valueInt('total');
    }
  }
?>
