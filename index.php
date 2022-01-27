<!DOCTYPE html>
<html lang="en">
  <head prefix="dc: http://purl.org/dc/elements/1.1 dcterms: http://purl.org/dc/terms">
    <meta charset='utf-8' />
    <meta name="viewport" content="width = device-width, initial-scale = 1.0" />
    <title>Köln-Wetter</title>
    <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
    <link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
    <meta name="DC.id" content="j4e22004" />
    <meta name="DC.title" content="Köln-Wetter" />
    <meta name="DC.description" content="Wetter, Pegelstand, Luftwerte u.a. in Köln." />
    <meta name="DC.subject" content="Köln, Wetter, Pegel, Schadstoffe" />
    <meta name="DC.creator" content="jochen4errors (j4e)" />
    <meta name="DC.date" content="2022-01-14" />
    <meta name="DCTERMS.license" content="https://creativecommons.org/licenses/by/4.0/" />
    <link rel="icon" type="image/x-icon" href="../../img/j4e.ico" />
    <link rel="stylesheet" href="../../css/box.css" />
    <link rel="stylesheet" href="../../css/flex.css" />
    <?php
      include('key.php');
      // Wetter: OpenWeatherMap
      $wetter_array = simplexml_load_file($wetter_url);
      // Pegel: Stadt Köln
      $quelle_pegel_url = 'https://www.stadt-koeln.de/interne-dienste/hochwasser/pegel_ws.php';
      $quelle_pegel_array = simplexml_load_file($quelle_pegel_url);
    ?>
  </head>
  <body>
    <header>
      <h1 style="color:black;">Köln-Wetter</h1>
    </header>
    <main>
      <div class="box wert">
        <table>
          <tr>
            <td class="hauptwert" rowspan="3">🌡️</td>
            <td class="hauptwert">
              <?php echo round($wetter_array->temperature[0]->attributes()->value , 1); ?>
            </td>
          </tr>
          <tr>
            <td class="nebenwert">
              <?php echo 'gefühlt ' , round($wetter_array->feels_like[0]->attributes()->value , 1); ?>
            </td>
          </tr>
          <tr>
            <td>
              <?php echo round($wetter_array->temperature[0]->attributes()->min , 1) , "…" , round($wetter_array->temperature[0]->attributes()->max , 1); ?>
            </td>
          </tr>
          <tr>
            <td>
               💦
            </td>
            <td class="hauptwert">
               <?php echo $wetter_array->humidity[0]->attributes()->value; ?>
            </td>
          <tr>
            <td>
               🗜️
            </td>
            <td class="hauptwert">
              <?php echo $wetter_array->pressure[0]->attributes()->value; ?>
            </td>
          </tr>
        </table>
      </div>

      <div class="box wert">
        <table>
          <tr>
            <td class="hauptwert">☂️</td>
            <td class="hauptwert">
              <?php
                if (strlen($wetter_array->precipitation[0]->attributes()->value) == 0){
                  echo '-';
                  } else {
                  echo $wetter_array->precipitation[0]->attributes()->value;
                  echo '<br />';
                  echo $wetter_array->precipitation[0]->attributes()->mode;
                  }
              ?>
            </td>
          </tr>
          <tr>
            <td rowspan="3" class="hauptwert">🌬️</td>
            <td>
              <?php echo round(($wetter_array->wind[0]->speed[0]->attributes()->value) * 3.600 ,1); ?> km/h
            </td>
          </tr>
          <tr>
            <td class="nebenwert">
              <?php echo $wetter_array->wind[0]->direction->attributes()->code; ?>
          </tr>
          <tr>
            <td class="nebenwert">
              <?php echo $wetter_array->wind[0]->speed->attributes()->name; ?>
            </td>
          </tr>
          <tr>
            <td class="hauptwert">☁️️</td>
            <td class="nebenwert">
              <?php echo $wetter_array->clouds[0]->attributes()->name; ?>      
            </td>
          </tr>
          <tr>
            <td class="hauptwert">👁️</td>
            <td>
              <?php echo $wetter_array->visibility[0]->attributes()->value; ?> m
            </td>
          </tr>
        </table>
      </div>

      <!--Pegel -->
      <div class="box wert">
        <table>
          <tr>
            <td>
              <?php echo '<img src="https://www.stadt-koeln.de/images/hochwasser/' , $quelle_pegel_array->Grafik[0] , '" alt="Wettericon">'; ?>
            </td>
          </tr>
          <tr>
            <td>
              📏 <?php echo $quelle_pegel_array->Pegel[0]; ?>
            </td>
          </tr>
          <tr>
            <td>
              🕓 <?php echo $quelle_pegel_array->Uhrzeit[0]; ?>
            </td>
          </tr>
        </table>
      </div>
      
      <!-- Zeit -->
      <div class="box wert">
        <table>
          <tbody>
          <tr>
            <td colspan="2" class="hauptwert">Zeiten</td>
          </tr>
          </tbody>
          <tbody style="border-top:solid black 1px;">
          <tr>
            <td>🔃</td>
            <td><?php echo $wetter_array->lastupdate[0]->attributes()->value; ?></td>
          </tr>
          <tr>
            <td>🌅</td>
            <td><?php echo $wetter_array->city[0]->sun->attributes()->rise; ?></td>
          </tr>
          <tr>
            <td>🌇</td>
            <td><?php echo $wetter_array->city[0]->sun->attributes()->set; ?></td>
          </tr>
          </tbody>
        </table>
      </div>
    </main>
    <footer style="color:black; ">
      <h2>Quellen:</h2>
      <ul>
        <li>Wetter: <a href="https://openweathermap.org" rel="source" target="_blank">Openweathermap</a></li>
        <li>Pegel: <a href="https://www.offenedaten-koeln.de/" rel="source" target="_blank">Offenedaten Koeln</a></li>
      </ul>
      <h2>Kontakt:</h2>
      <address>
        <a href="https://twitter.com/Jochen4Errors" target="_blank" rel="author"><img id="kontakt" src="../../img/Twitter-logo.svg" alt="Twitter-Logo" height="30" width="30" /></a>
        &nbsp;
        <a href="https://github.com/jochen4errors" target="_blank" rel="author"><img id="kontakt" src="../../img/Font_Awesome_5_brands_github.svg" alt="Github-Logo" height="30" width="30" /></a>
      </address>
    </footer>
  </body>
</html>
