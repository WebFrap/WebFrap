<h1>Roles</h1>

<p>
Rollen haben mehrere Anwendungsgebiete, unter anderem jedoch werden über die Rollen
die ACLs implementiert.
Zuallererst haben Rollen wie User ein <span class="key_word">User-Level</span>.
</p>

<p>
Ein Benutzer der einer Rolle direkt zugewiesen wird
erbt die User-Level aller Rollen, einfacher gesagt, das größte Level, sollte eines der Rollen sein persönliches
übersteigen wird das neue User-Level.
</p>

<p>Es gibt verschiedene Relationsvarianten für die Zuweisung eines Users zu einer Rolle.</p>

<img src="./images/buiz_guidance/acl/user_role_asgd.png" alt="User / Role Assignment" />

<br />
<br />


<table class="doc_grid centered" >
  <label>Eine kleine Tabelle zum verdeutlichen der möglichen Relationen</label>
  <thead>
    <tr>
      <th>Role</th>
      <th>Area</th>
      <th>Dataset</th>
      <th>Value</th>
      <th>Has Role</th>
      <th>Desc</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>admin</td>
      <td>-</td>
      <td>-</td>
      <td>admin</td>
      <td>Mitglied Rolle <span class="role" >admin</span>?</td>
      <td><span class="true" >true</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>-</td>
      <td>-</td>
      <td>admin:mgmt-project_project</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project</span>?</td>
      <td><span class="true" >true</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mod-project</td>
      <td>-</td>
      <td>admin:mgmt-project_project</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project</span>?</td>
      <td><span class="true" >true</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mod-project</td>
      <td>-</td>
      <td>admin:mgmt-enterprise_employee</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-enterprise_employee</span>?</td>
      <td><span class="false" >false</span></td>
    </tr>
    <tr>
      <td>manager</td>
      <td>mod-project</td>
      <td>-</td>
      <td>admin:mgmt-project_project</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project</span>?</td>
      <td><span class="false" >false</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mgmt-project_project</td>
      <td>42</td>
      <td>admin:mgmt-project_project</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project</span>?</td>
      <td><span class="false" >false</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mgmt-project_project</td>
      <td>42</td>
      <td>admin:mgmt-project_project:42</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project</span> Datensatz 42?</td>
      <td><span class="true" >true</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mgmt-project_project</td>
      <td>42</td>
      <td>admin:mgmt-project_project-mask-plan:42</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project-mask-plan</span> Datensatz 42?</td>
      <td><span class="true" >true</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mgmt-project_project</td>
      <td>-</td>
      <td>admin:mgmt-project_project-mask-plan:42</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project-mask-plan</span> Datensatz 42?</td>
      <td><span class="true" >true</span></td>
    </tr>
    <tr>
      <td>admin</td>
      <td>mgmt-project_project-mask-plan</td>
      <td>-</td>
      <td>admin:mgmt-project_project</td>
      <td>Mitglied Rolle <span class="role" >admin</span> in Relation zu <span class="sec_area" >mgmt-project_project</span>?</td>
      <td><span class="false" >false</span></td>
    </tr>
  </tbody>
</table>

<p>
Zum besseren Verständnis: <span class="sec_area" >mgmt-project_project-mask-plan</span> ist ein 
Management Knoten von <span class="sec_area" >mgmt-project_project</span> und beerbt daher
seine Berechtigungen.
</p>

