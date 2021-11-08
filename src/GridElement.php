<?php

namespace Tyler\ElementalExtension;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\ClassInfo;

class GridElement extends BaseElement {

	private static $table_name = 'GridElement';

	private static $singular_name = 'Grid Element';
	private static $plural_name = 'Grid Elements';
	private static $description = 'Grid Layout Content';

	private static $inline_editable = false;

	private static $db = [
		'DesktopWidth' => 'Int',
		'PhoneWidth' => 'Int'
	];

	private static $has_many = [
		'GridSections' => GridSection::class
	];

    public function getType()
    {
        return 'Grid Element';
    }

    /**
     * @param string $suffix
     *
     * @return array
     */
    public function getRenderTemplates($suffix = '')
    {
        $classes = ClassInfo::ancestry($this->ClassName);
        $classes[static::class] = static::class;
        $classes = array_reverse($classes);
        $templates = [];

        foreach ($classes as $key => $class) {
            if ($class == BaseElement::class) {
                continue;
            }

            if ($class == DataObject::class) {
                break;
            }

            if ($style = $this->Style) {
                $templates[$class][] = $class . $suffix . '_'. $this->getAreaRelationName() . '_' . $style;
                $templates[$class][] = $class . $suffix . '_' . $style;
            }
            $templates[$class][] = $class . $suffix . '_'. $this->getAreaRelationName();
            $templates[$class][] = $class . $suffix;
            $templates[$class][$this->ClassName] = 'GridElement';
        }

        $this->extend('updateRenderTemplates', $templates, $suffix);

        $templateFlat = [];
        foreach ($templates as $class => $variations) {
            $templateFlat = array_merge($templateFlat, $variations);
        }

        return $templateFlat;
    }
}