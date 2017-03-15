<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #dddddd;
}
</style>
</head>
<body>
<h1>Anketa Servis</h1>
<table>
  <tr>
    <th>Route</th>
    <th>Method</th>
    <th>Params</th>
     <th>Description</th>
  </tr>
  <tr>
    <td>mojhost/ci-cms2/anketa/server</td>
    <td>GET</td>
    <td></td>
      <td>Pocetna strana</td>
  </tr>
  <tr>
    <td>/mojhost/ci-cms2/anketa/server/get/</td>
    <td>GET</td>
    <td></td>
      <td>Vraca niz svih anketa</td>
  </tr>
  <tr>
  <td>/mojhost/ci-cms2/anketa/server/get/</td>
    <td>GET</td>
    <td>ID</td>
     <td>Vraca niz objekata odredjene ankete</td>
  </tr>
  <tr>
    <td>/mojhost/ci-cms2/anketa/server/post/</td>
    <td>POST</td>
    <td>ID</td>
     <td>Vraca obavestenje o izvrsenom glasanju, prekoracenom limitu pozivanja servisa... status/error</td>
  </tr>
</table>
</body>
</html>



