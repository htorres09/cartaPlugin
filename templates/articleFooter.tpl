{**
 * plugins/generic/cartaPlugin/templates/articleFooter.tpl
 * Héctor Torres - Universidad Autónoma de Nuevo León
 * hector.torresg@uanl.mx
 * Distributed under the GNU GPL v3. For full terms see the file LICENCSE
 *
 * Template para ser incluido vía Templates::Article::Footer::PageFooter hook.
 *}

 <div id="cartaPdf">
     <h3>{translate key="plugins.generic.cartaPDF.header"}</h3>
     {if !$cartaPDF->wasEmpty()}
        <ul>
            <li><a href="crearCarta.php" target="_blank">Certificado</a></li>
        </ul>
     {/if}
 </div>
