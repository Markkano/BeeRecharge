<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Insertar Beer</title>
  </head>
  <body>
    <style media="screen">
      table td{
        padding: 10px;
      }
      input {
        width: 100%;
      }
    </style>
    <form class="" action="/<?= BASE_URL ?>insert/Insert" method="post">
      <table style="margin: auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
          <td><label for="name">name</label></td>
          <td><input type="text" name="name" value=""></td>
        </tr>
        <tr>
          <td><label for="description">description</label></td>
          <td><input type="text" name="description" value=""></td>
        </tr>
        <tr>
          <td><label for="price">price</label></td>
          <td><input type="number" step="0.1" min="0" name="price" value=""></td>
        </tr>
        <tr>
          <td><label for="graduation">graduation</label></td>
          <td><input type="number" step="0.1" min="0" name="graduation" value=""></td>
        </tr>
        <tr>
          <td><label for="ibu">ibu</label></td>
          <td><input type="number" step="0.1" min="0" name="ibu" value=""></td>
        </tr>
        <tr>
          <td><label for="srm">srm</label></td>
          <td><input type="number" step="0.1" min="0" name="srm" value=""></td>
        </tr>
        <tr>
          <td><label for="image">image</label></td>
          <td><input type="text" name="image" value=""></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="" value="Insertar"></td>
        </tr>
      </table>
    </form>
  </body>
</html>
