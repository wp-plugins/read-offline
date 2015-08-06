<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2014 Michael Uno; Licensed MIT
 * 
 */
if ( ! class_exists( 'AdminPageFramework_MetaBox_View' ) ) :
/**
 * Handles displaying meta box outputs.
 *
 * @abstract
 * @since           3.3.0
 * @package         AdminPageFramework
 * @subpackage      MetaBox
 */
abstract class AdminPageFramework_MetaBox_View extends AdminPageFramework_MetaBox_Model {
    
    /**
     * Echoes the meta box contents.
     * 
     * @since       2.0.0
     * @remark      A callback for the `add_meta_box()` method.
     * @param       object      $oPost      The object of the post associated with the meta box.
     * @param       array       $vArgs      The array of arguments.
     * @return      void
     * @internal    
     */ 
    public function _replyToPrintMetaBoxContents( $oPost, $vArgs ) {    

        // Use nonce for verification
        $_aOutput   = array();
        $_aOutput[] = wp_nonce_field( $this->oProp->sMetaBoxID, $this->oProp->sMetaBoxID, true, false );
        
        // Condition the sections and fields definition arrays.
        $this->oForm->applyConditions(); // will set $this->oForm->aConditionedFields internally
        $this->oForm->applyFiltersToFields( $this, $this->oProp->sClassName );
        
        // Set the option array - the framework will refer to this data when displaying the fields.
        if ( isset( $this->oProp->aOptions ) ) {
            $this->_setOptionArray( 
                isset( $oPost->ID ) ? $oPost->ID : ( isset( $_GET['page'] ) ? $_GET['page'] : null ), 
                $this->oForm->aConditionedFields 
            ); // will set $this->oProp->aOptions
        }
        
        // Add the repeatable section elements to the fields definition array.
        $this->oForm->setDynamicElements( $this->oProp->aOptions ); // will update $this->oForm->aConditionedFields
                            
        // Get the fields output.
        $_oFieldsTable  = new AdminPageFramework_FormTable( $this->oProp->aFieldTypeDefinitions, $this->_getFieldErrors(), $this->oMsg );
        $_aOutput[]     = $_oFieldsTable->getFormTables( $this->oForm->aConditionedSections, $this->oForm->aConditionedFields, array( $this, '_replyToGetSectionHeaderOutput' ), array( $this, '_replyToGetFieldOutput' ) );

        /* Do action */
        $this->oUtil->addAndDoActions( $this, 'do_' . $this->oProp->sClassName, $this );
        
        /* Render the filtered output */
        echo $this->oUtil->addAndApplyFilters( $this, 'content_' . $this->oProp->sClassName, implode( PHP_EOL, $_aOutput ) );

    }
    
    
    
}
endif;