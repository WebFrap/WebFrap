<h1>Security-Areas</h1>

<p>Für alle relevanten Elemente in der WebFrap Architektur gibt es so genannte Security Areas
welche diese in den ACLs repräsentieren.</p>

<div style="width:460px;float:left;" >
<img src="./images/buiz_guidance/acl/sec_area.png" alt="Sec Area" />
</div>

<div style="width:330px;float:left;" >

<p>
Die Areas sind eineinander verschachtelt, und erben jeweils die Rechte
der Vater Area. Rechte die auf der Modulearea zugewiesen werden, 
werden also bis auf die Attribute vererbt, wenn keine zusätzlichen Rechte
gesetzt werden.
</p>

<p>
Rechte können in den tieferen Ebenen nur erweitert, nicht aber eingeschränkt werden.
Werde auf dem Modul z.B. Löschrechte vergeben, kann der Anwender jeden Datensatz 
innerhalb des Modules löschen, ohne dass die Berechtigungen auf einer tieferen
Ebene eingeschränkt werden können. Daher ist gerade mit Berechtigungen auf Modul
oder Entity Ebene sparsam umzugehen.
</p>

<p>
Berechtigungen werden in Pfaden angegeben: <span class="acl_path" >mod-project/mgmt-project_project/mgmt-project_mask_planning</span>
</p>
</div>

<div style="clear:both;" >&nbsp;</div>

<h2>Security Area Typen</h2>

<ul class="doc_tree" >
  <li><span>module</span> Repräsentiert ein Modul</li>
  <li><span>module_category</span> "" eine Modul Category (Gruppe von Entities und Masken)</li>
  <li><span>entity</span> "" eine Entity (Datenknoten)</li>
  <li><span>entity_reference</span> "" eine Entity-Reference (Referenzen zwischen den Datenknoten)</li>
  <li><span>entity_category</span> "" eine Entity Category ( Gruppe von Attribute innerhalb einer Entity und ihrer One To One Referenzen) </li>
  <li><span>entity_attribute</span> "" ein Attribute </li>
  <li><span>mgmt</span> "" ein Management Knoten (Spezialisierter Verwaltungsknoten für eine Entity)</li>
  <li><span>mgmt_reference</span> "" eine Reference auf Management Ebene (Nicht alle Referenzen der Entity müssen bei jedem Management Node vorhanden sein)</li>
  <li><span>page</span> "" eine Frontend Webseite </li>
  <li><span>widget</span> "" ein Widget Element </li>
  <li><span>item</span> "" ein Item Element </li>
</ul>


<h2>Datenmodell der Security-Area</h2>

<?php start_highlight(); ?>
<entities>
  <entity name="wbfsys_security_area" >
    <attributes>

      <attribute is_a="label" >
        <search type="true" ></search>
        <display>
          <text />
          <input />
          <listing />
          <selection />
        </display>
      </attribute>
      
      <attribute 
        name="id_ref_listing" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_ref_access" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_ref_insert" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_ref_update" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_ref_delete" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_ref_admin" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_level_listing" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_level_access" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_level_insert" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_level_update" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_level_delete" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute 
        name="id_level_admin" 
        type="int" 
        target="wbfsys_security_level" 
        target_field="level" >
        <uiElement type="selectbox" />
      </attribute>
      
      <attribute is_a="vid" ></attribute>

      <attribute name="id_target" target="wbfsys_security_area" >
        <description>
          <text lang="de" >id_target wird benötigt wenn die security area 
vom type reference ist und auf eine andere entity verweist</text>
        </description>
      </attribute>

      <attribute is_a="type" ></attribute>
      <attribute is_a="access_key" validator="ckey" ></attribute>
      <attribute name="type_key" is_a="access_key" validator="ckey" ></attribute>
      <attribute name="parent_key" is_a="access_key" validator="ckey" ></attribute>
      <attribute name="source_key" is_a="access_key" validator="ckey" ></attribute>
      <attribute name="id_source" target="wbfsys_security_area" ></attribute>
      <attribute name="parent_path" type="text" size="500" ></attribute>
      <attribute name="revision" type="int" ></attribute>
      <attribute name="flag_system" type="boolean" >
        <description>
          <text lang="de" >
            Wenn true wurde diese SecArea vom System per BDL / Modul angelegt. 
            Von Hand erstellte SecAreas müsse auf false gesetzt werden.
            SecAreas mit dem Wert true werden in den Consistency Checks gelöscht wenn diese nicht
            die aktuellste deployment version besitzen, was bei händisch erstellen Areas nie der
            Fall sein dürfte.
          </text>
        </description>
      </attribute>
      <attribute is_a="description" ></attribute>
    </attributes>
  
  </entity>

</entities>
<?php display_highlight( 'xml' ); ?>



