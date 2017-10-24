# aktiv-kommune-api
API for Aktiv kommune - (Portico)

**Installasjon:**

>Disse filene installeres i .../portico/api

**Liste over API'er og eksempler på bruk:**

>_activity/read.php_ - Viser en liste med aktiviteter fra bb_activity.

eks. på bruk: http://aktiv.fjell.no/aktivivest/api/activity/read.php

>_activity_json.php_ - Viser en liste med aktiviteter fra bb_activity. Kan også inneholde html kode som benyttes i Wordpress (Alchem Pro Child) 

eks. på bruk: http://aktiv.fjell.no/aktivivest/api/activity/activity_json.php?html_code=1&csv_create=1

>Lager filene html_activity.json og actvity.csv i samme mappe 

>Brukes http://aktiv.fjell.no/aktivivest/api/activity/activity_json.php lages kun filen activity.json

Endre config/system.php slik at den passer behovene.
