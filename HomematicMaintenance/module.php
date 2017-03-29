<?
    // Klassendefinition
    class HomematicMaintenance extends IPSModule {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
 
            // Selbsterstellter Code
        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

            // Variables
           $this->RegisterPropertyInteger("HM_TIMEOUT_REFRESH", 10);
           $this->RegisterPropertyBoolean("servicemsgs", true);
           $this->RegisterPropertyBoolean("RSSI", true);
 
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();

            // Refresh Script
            $refreshScriptID = @$this->GetIDForIdent("update");
            if($refreshScriptID === false) {
                $refreshScriptID = $this->RegisterScript("update", "Update", file_get_contents(__DIR__ . "/update.php"), 100);
            } 
            else {
            IPS_SetScriptContent($refreshScriptID, file_get_contents(__DIR__ . "/update.php"));
            }
            IPS_SetHidden($refreshScriptID, true);

            // Refresh Ereignis
            $refreshEvent = @IPS_GetEventIDByName("Ereignis", $refreshScriptID);
            if(!$refreshEvent) {
                $refreshEvent = IPS_CreateEvent(1);
                IPS_SetParent($refreshEvent, $refreshScriptID);
                IPS_SetName($refreshEvent, "Ereignis");
                IPS_SetEventCyclicTimeFrom($refreshEvent, 0, 1, 0);
                IPS_SetEventActive($refreshEvent, true);
            }



        }
 
        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
        public function MeineErsteEigeneFunktion() {
            // Selbsterstellter Code
            echo $this->InstanceID;

            if(IPS_GetProperty($this->InstanceID, "HM_TIMEOUT_REFRESH")){
                echo "Timeout";
                }
            if (IPS_GetProperty($this->InstanceID, "RSSI")){
                echo "RSSI";
                }
            if (IPS_GetProperty($this->InstanceID, "servicemsgs")) {
                echo "servicemsgs";
                }

        }


        // PUBLIC ACCESSIBLE FUNCTIONS
        public function Update() {
            $this->MeineErsteEigeneFunktion();
    }
    }
?>