<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php'; ?>

<div class="container secondary">
    <div class="container-inner">
        <form>
            <h1>Settings &amp; Configurations</h1>
            
            <div id="settings-status-message"></div>
            
            <h2>It's all about me</h2>
            
            <p>
                <label>My name</label>
                <input type="text" id="setting-name" value="<?=Model_Format::parseHtml($user->getInfo('user_name'))?>" class="textbox" /><br />
                
                <label>My email is</label>
                <input type="text" id="setting-email" value="<?=Model_Format::parseHtml($user->getInfo('user_email'))?>" class="textbox" /><br />
            </p>
            
            <h2>Functional</h2>
            
            <p>
                <label>Autosave</label>
                <select id="setting_autosave">
                    <option value="1" <?=($settings->getSetting('setting_autosave') == '1' ? 'selected="selected"' : '')?>>Yes, every 15 seconds</option>
                </select><br />
            </p>
            
            <h2>Visual</h2>
    
            <p>    
                <label>Font family</label>
                <select id="setting_font_family">
                    <option value="palatino"  <?=($settings->getSetting('setting_font_family') == 'palatino'  ? 'selected="selected"' : '')?>>Palatino</option>
                    <option value="georgia"   <?=($settings->getSetting('setting_font_family') == 'georgia'   ? 'selected="selected"' : '')?>>Georgia</option>
                    <option value="helvetica" <?=($settings->getSetting('setting_font_family') == 'helvetica' ? 'selected="selected"' : '')?>>Helvetica</option>
                    <option value="arial"     <?=($settings->getSetting('setting_font_family') == 'arial'     ? 'selected="selected"' : '')?>>Arial</option>
                </select><br />
                
                <label>Font size</label>
                <select id="setting_font_size">
                    <option value="10" <?=($settings->getSetting('setting_font_size') == '10' ? 'selected="selected"' : '')?>>Tiny</option>
                    <option value="12" <?=($settings->getSetting('setting_font_size') == '12' ? 'selected="selected"' : '')?>>Small</option>
                    <option value="14" <?=($settings->getSetting('setting_font_size') == '14' ? 'selected="selected"' : '')?>>Medium</option>
                    <option value="16" <?=($settings->getSetting('setting_font_size') == '16' ? 'selected="selected"' : '')?>>Kinda big</option>
                    <option value="18" <?=($settings->getSetting('setting_font_size') == '18' ? 'selected="selected"' : '')?>>Big</option>
                    <option value="22" <?=($settings->getSetting('setting_font_size') == '22' ? 'selected="selected"' : '')?>>Massive</option>
                </select><br />
                
                <label>Font colour</label>
                <select id="setting_font_color">
                    <option value="000" <?=($settings->getSetting('setting_font_color') == '000' ? 'selected="selected"' : '')?>>Black</option>
                    <option value="444" <?=($settings->getSetting('setting_font_color') == '444' ? 'selected="selected"' : '')?>>Charcoal</option>
                    <option value="888" <?=($settings->getSetting('setting_font_color') == '888' ? 'selected="selected"' : '')?>>Grey-er</option>
                    <option value="CCC" <?=($settings->getSetting('setting_font_color') == 'CCC' ? 'selected="selected"' : '')?>>Grey</option>
                </select><br />
                
                <label>Line height</label>
                <select id="setting_line_height">
                    <option value="1.0" <?=($settings->getSetting('setting_line_height') == '1.0' ? 'selected="selected"' : '')?>>Tiny</option>
                    <option value="1.2" <?=($settings->getSetting('setting_line_height') == '1.2' ? 'selected="selected"' : '')?>>Small</option>
                    <option value="1.4" <?=($settings->getSetting('setting_line_height') == '1.4' ? 'selected="selected"' : '')?>>Medium</option>
                    <option value="1.6" <?=($settings->getSetting('setting_line_height') == '1.6' ? 'selected="selected"' : '')?>>Kinda big</option>
                    <option value="1.8" <?=($settings->getSetting('setting_line_height') == '1.8' ? 'selected="selected"' : '')?>>Big</option>
                    <option value="2.2" <?=($settings->getSetting('setting_line_height') == '2.2' ? 'selected="selected"' : '')?>>Massive</option>
                </select><br />
                
                <label>Alignment</label>
                <select id="setting_alignment">
                    <option value="left"    <?=($settings->getSetting('setting_alignment') == 'left'    ? 'selected="selected"' : '')?>>Left</option>
                    <option value="center"  <?=($settings->getSetting('setting_alignment') == 'center'  ? 'selected="selected"' : '')?>>Center</option>
                    <option value="right"   <?=($settings->getSetting('setting_alignment') == 'right'   ? 'selected="selected"' : '')?>>Right</option>
                    <option value="justify" <?=($settings->getSetting('setting_alignment') == 'justify' ? 'selected="selected"' : '')?>>Justify</option>
                </select><br />
                
                <label>Background</label>
                <select id="setting_background">
                    <option value="wood"     <?=($settings->getSetting('setting_background') == 'wood'     ? 'selected="selected"' : '')?>>Wood</option>
                    <option value="squares"  <?=($settings->getSetting('setting_background') == 'squares'  ? 'selected="selected"' : '')?>>Squares</option>
                    <option value="white"    <?=($settings->getSetting('setting_background') == 'white'    ? 'selected="selected"' : '')?>>White</option>
                    <option value="grey"     <?=($settings->getSetting('setting_background') == 'grey'     ? 'selected="selected"' : '')?>>Grey</option>
                    <option value="greyer"   <?=($settings->getSetting('setting_background') == 'greyer'   ? 'selected="selected"' : '')?>>Grey-er</option>
                    <option value="charcoal" <?=($settings->getSetting('setting_background') == 'charcoal' ? 'selected="selected"' : '')?>>Charcoal</option>
                    <option value="black"    <?=($settings->getSetting('setting_background') == 'black'    ? 'selected="selected"' : '')?>>Black</option>
                </select><br />
                
                <label>Page padding</label>
                <select id="setting_page_paddings">
                    <option value="50"  <?=($settings->getSetting('setting_page_paddings') == '50'  ? 'selected="selected"' : '')?>>Small</option>
                    <option value="75"  <?=($settings->getSetting('setting_page_paddings') == '75'  ? 'selected="selected"' : '')?>>Medium</option>
                    <option value="100" <?=($settings->getSetting('setting_page_paddings') == '100' ? 'selected="selected"' : '')?>>Kinda big</option>
                    <option value="125" <?=($settings->getSetting('setting_page_paddings') == '125' ? 'selected="selected"' : '')?>>Big</option>
                    <option value="150" <?=($settings->getSetting('setting_page_paddings') == '150' ? 'selected="selected"' : '')?>>Massive</option>
                </select><br />
                
                <label>Display comments</label>
                <select id="setting_display_comments">
                    <option value="1" <?=($settings->getSetting('setting_display_comments') == '1' ? 'selected="selected"' : '')?>>Yes, show me the comments!</option>
                    <option value="0" <?=($settings->getSetting('setting_display_comments') == '0' ? 'selected="selected"' : '')?>>No, hide them for now</option>
                </select><br />
                
                <label>&nbsp;</label>
                <a href="#" id="settings-save" class="button orange bigrounded">Save Settings &amp; Configurations</a>
            </p>
        </form>
    </div>
</div>