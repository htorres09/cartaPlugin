<?php

/**
 * @file plugins/generic/carta/CartaHandler.php
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 *
 * @class cartaPDF
 * @ingroup plugins_generic_cartaPDF
 * @brief Carta PDF Plugin
 */
import('lib.pkp.classes.plugins.GenericPlugin');

class cartaPDF extends GenericPlugin{
    function register($category, $path){
        $success = parent::register($category, $path);

        if(!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return $success;
        
        if($success && $this->getEnabled() )
        {
            HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'callbackTemplateArticlePageFooter'));
        }
        return $success;
    }

    function callback($hookName, $args){
        //CODE HERE
    }

    function getName(){ return 'cartaPlugin'; }

    function getDisplayName(){
        return "Plugin Carta de Aceptación PDF";
    }

    function getDescription(){
        return "Permite crear una carta de Aceptación PDF";
    }

    /**
     * Get the filename of the ADODB schema for this plugin
     */
    function getInstallSchemaFile(){
        return $this->getPluginPath() . '/' . 'schema.xml';
    }

    /**
     * Set the enabled/disabled state of the plugin
     */
    function setEnabled($enabled){
        parent::setEnabled($enabled);
        $journal =& Request::getJournal();
        return false;
    }

    function displayHeaderLink($hookName, $params){
        $journal =& Request::getJournal();
        if(!$journal){
            return false;
        }

        if($this->getEnabled()){
            $smarty =& $params[1];
            $output =& $params[2];
            $TemplateMgr = TemplateManager::getManager();
            $output .= '<li><a href="'
                        . $templateMgr->smartyUrl(array('page'=>'statistics'), $smarty)
                        . '" target="_parent">'
                        . $templateMgr->smartyTranslate(array('key'=>'plugins.generic.carta.name'), $smarty)
                        . '</a></li>';
        }
        return false;
    }

    function handleRequest($hookName, $args){
        $page =& $args[0];
        $op =& $args[1];
        $sourceFile =& $args[2];

        // If the request is for the log analyzer itself, handle it.
		if ($page === 'carta') {
			$this->import('CartaHandler');
			Registry::set('plugin', $this);
			define('HANDLER_CLASS', 'CartaHandler');
			return true;
		}
		return false;
    }

    function isSitePlugin(){
        return true;
    }
     /**
      * Display verbs for the managment interface
      */
    function getManagementVerbs(){
        $verbs = array();
        if($this->getEnabled()){
            $verbs[] = array('settings', Locale::translate('plugins.generic.cartaPDF.manager.settings'));
        }
        return parent::getManagerVerbs($verbs);
    }

    /*
 	 * Execute a management verb on this plugin
 	 * @param $verb string
 	 * @param $args array
	 * @param $message string Location for the plugin to put a result msg
 	 * @return boolean
 	 */
    function manage($verb, $args, &$message) {
		if (!parent::manage($verb, $args, $message)){
            return false;
        }

        switch ($verb) {
			case 'carta':
				Request::redirect(null, 'carta');
				return false;
			default:
				// Unknown management verb
				assert(false);
				return false;
		}
	}
}
?>
