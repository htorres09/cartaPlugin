<?php
/**
 * @file plugins/generic/cartaPlugin/cartaPDF.inc.php
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 * Distributed under the GNU GPL v3. For full terms see the file LICENCSE
 *
 * @class cartaPDF
 * @ingroup plugins_generic_cartaPDF
 * @brief Carta PDF Plugin
 */
import('lib.pkp.classes.plugins.GenericPlugin');
/*require_once($configGeneral["pathFPDF"]);*/

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

    function getName(){ return 'cartaPlugin'; }

    function getDisplayName(){
        return "Plugin Carta de Aceptación PDF";
    }

    function getDescription(){
        return "Permite crear una carta de Aceptación PDF";
    }

    function getTemplatePath($inCore = false){
        return parent::getTemplatePath($inCore) . 'templates/';
    }

    function callbackTemplateArticlePageFooter($hookName, $params){
        $smarty =& $params[1];
        $output =& $params[2];

        $displayedArticle = $smarty->get_template_vars('article');
        $authors = $displayedArticle->getAuthors();
        $titulo = $displayedArticle->getTitle();
        $status = $displayedArticle->getStatus();
        $fechaSubmit = $displayedArticle->getDateSubmited();
        $fechaMod = $displayedArticle->getDateStatusModified();
        $authorDao = DAORegistry::getDAO('AuthorDAO');

        $nombres = [];
        foreach ($authors as $author) {
            $nombres[] = $author->getFullName();
        }
        $resultado = [];
        array_push($resultado,
                    'titulo'=>$title,
                    'autores'=>$nombres,
                    'fechaSubmit' => $fechaSubmit,
                    'fechaAceptada' => $fechaMod,
                    'status'=>$status);

        // Visualizar
        //import('lib.pkp.classes.core.VirtualArrayIterator');
        //returner = new VirtualArrayIterator($resultado, 1, 1, 1);
        $query = http_build_query($resultado);
        $returner = "<a href='crearCarta.php?'" . $query . "' target='_blank'>";
        $smarty->assign('cartaPDF', returner);
        $output .= $smarty->fetch($this->getTemplatePath() . 'articleFooter.tpl');
    }

    /*function crearCarta($params){
        $lineCount = 0;

        $pdf = new Carta();
        $pdf->AddPage();
        $pdf->SetFont("font", "", 12);
        $pdf->Ln(65);
        $pdf->Cell(165, 10, $params['fechaAceptada'], 0, 0, "R");
        $pdf->Ln(35);
        foreach ($params["autores"] as &$nombre) {
            $pdf->Cell(200, 5, $nombre, 0, 1, "C");
            $lineCount += 1;
        }
        $pdf->Ln(46 - $lineCount);
        $pdf->MultiCell(0, 5, $params["titulo"], 0, 0, "C");
        $pdf->Ln(13- $lineCount);
        $pdf->Cell(240, 5, $status, 0, 0);

        $pdf->Output("D", $params["fechaSubmit"]+"_"+$params["titulo"], true);
    }*/

    /**
     * Get the filename of the ADODB schema for this plugin
     */
    /*function getInstallSchemaFile(){
     *   return $this->getPluginPath() . '/' . 'schema.xml';
    }*/

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
