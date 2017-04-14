<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;


/**
 * Provides a 'ViewsCounterBlock' Block.
 *
 * @Block(
 *   id = "ViewsCounterBlock_block",
 *   admin_label = @Translation("ViewsCounterBlock block"),
 * )
 */
class ViewsCounterBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $nid = \Drupal::routeMatch()->getRawParameter('node');
//        $nid = $node->nid->value;
       //return $nid;
        $view = views_get_current_view();

        return [
            '#markup' => $this->t($nid.'-'.$view->name.'-'.$view->id),
];


    }


    /**
     * Implements hook_views_pre_render().
     */





    function db_table_exists($table) {

        return Database::getConnection()->schema()->tableExists($table);

    }

    /**
     * {@inheritdoc}
     */

    function db_insert($table, array $options = array()) {
        if (empty($options['target']) || $options['target'] == 'replica') {
            $options['target'] = 'default';
        }
        return Database::getConnection($options['target'])->insert('hello_db', $options);
    }

    /**
     * {@inheritdoc}
     */

    function db_select($table, $alias = NULL, array $options = array()) {
        if (empty($options['target'])) {
            $options['target'] = 'default';
        }
        return Database::getConnection($options['target'])->select('hello_db', $alias, $options);
    }
   // function db_field_names($fields) {
    //    return Database::getConnection()->schema()->fieldNames($fields);
   // }

    /**
     * {@inheritdoc}
     */

   function db_change_field($table, $field, $field_new, $spec, $keys_new = array()) {
      return Database::getConnection()->schema()->changeField($table, $field, $field_new, $spec, $keys_new);
    }



}