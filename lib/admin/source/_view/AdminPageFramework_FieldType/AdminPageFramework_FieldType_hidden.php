<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2014 Michael Uno; Licensed MIT
 * 
 */
if ( ! class_exists( 'AdminPageFramework_FieldType_hidden' ) ) :
/**
 * Defines the hidden field type.
 * 
 * @package AdminPageFramework
 * @subpackage FieldType
 * @since 2.1.5
 * @internal
 */
class AdminPageFramework_FieldType_hidden extends AdminPageFramework_FieldType_Base {
    
    /**
     * Defines the field type slugs used for this field type.
     */
    public $aFieldTypeSlugs = array( 'hidden' );
    
    /**
     * Defines the default key-values of this field type. 
     */
    protected $aDefaultKeys = array();
    
    /**
     * Loads the field type necessary components.
     */ 
    public function _replyToFieldLoader() {
    }    
    
    /**
     * Returns the field type specific JavaScript script.
     */ 
    public function _replyToGetScripts() {
        return "";     
    }    

    /**
     * Returns the field type specific CSS rules.
     */ 
    public function _replyToGetStyles() {
        return "";     
    }
    
    /**
     * Returns the output of the field type.
     * 
     * @remark The user needs to assign the value to either the default key or the vValue key in order to set the hidden field. 
     * If it's not set ( null value ), the below foreach will not iterate an element so no input field will be embedded.
     * 
     * @since 2.0.0
     * @since 2.1.5 Moved from the AdminPageFramework_FormField class. The name was changed from getHiddenField().
     * @since 3.0.0 Removed unnecessary elements including the parameters.
     */
    public function _replyToGetField( $aField ) {

        return 
            $aField['before_label']
            . "<div class='admin-page-framework-input-label-container'>"
                . "<label for='{$aField['input_id']}'>"
                    . $aField['before_input']
                    . ( $aField['label']
                        ? "<span class='admin-page-framework-input-label-string' style='min-width:" . $this->sanitizeLength( $aField['label_min_width'] ) . ";'>" . $aField['label'] . "</span>"
                        : "" 
                    )
                    . "<input " . $this->generateAttributes( $aField['attributes'] ) . " />" // this method is defined in the base class
                    . $aField['after_input']
                . "</label>"
            . "</div>"
            . $aField['after_label'];
        
    }
    
}
endif;