<?php
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
require_once '/var/www/wordpress/cedilleTest/wp-load.php';
//require_once dirname(__FILE__) . '/../bootstrap.php';




class TestCedilleFormation extends \PHPUnit\Framework\TestCase
{
    public function test_catalogue_contains_at_least_one_course()
    {
        $args = array(
            'post_type' => 'formations',
            'post_per_page' => -1
        );
        $courses = get_posts($args);

        $this->assertNotEmpty($courses);
    }

    public function test_program_contains_all_fieldname_required()
    {
        $required_fields = [
            'formation_name',
            'teacher_carte',
            'formation_locate',
            'tarif_archive',
            'objectif_formation',
            'type_public',
            'pre-requis',
            'formation_content',
            'teachers',
            'modalites_pedagogiques',
            'modalites_techniques',
            'evaluation',
            'delai_acces',
            'accessibilites',
            'tarif_formation',
            'duree_formation'
        ];
        $args = array(
            'post_type' => 'formations',
            'post_per_page' => 1
        );
        $course = get_posts($args);


        $fields = acf_get_fields($course[0]->ID);
        $fields_name = array_map(function ($field) {
            return $field['name'];
        }, $fields);
        
        $missing_fields = array_diff($required_fields, $fields_name);
        $this->assertEmpty($missing_fields, 'Les champs suivants sont manquants : ' . implode(', ', $missing_fields));
    }
}
