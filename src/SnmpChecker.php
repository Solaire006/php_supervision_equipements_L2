<?php
//classe snmpChecker pour la vérification des info par SNMP

class snmpChecker {
    private $ip;
    private $community;
    private $timeout;
    private $retries; 

    public function __construct($ip) {
        $this->ip = $ip;
        require_once __DIR__ . '/../config/snmp_config.php';
        $this->community = defined('SNMP_COMMUNITY') ? SNMP_COMMUNITY : 'public';
        $this->timeout = defined('SNMP_TIMOUT') ? SNMP_TIMOUT : 1000000;
        $this->retries = defined('SNMP_RETRIES') ? SNMP_RETRIES : 1;
    }

    //fonction pour retourner UP/DOWN
    public function getStatus() {
        $oid = '.1.3.6.1.2.1.1.1.0'; //oid pour sysDescr
        $result = @snmp2_get($this->ip, $this->community, $oid, $this->timeout, $this->retries);
        if ($result !== false) {
            return 'UP';
        } else {
            return 'DOWN';
        }
    }
    
    //fonction pour récup le nom du système
    public function getSysname() {
        $oid = '1.3.6.1.2.1.1.5.0';
        $result = @snmp2_get($this->ip, $this->community, $oid, $this->timeout, $this->retries);
        return ($result !== false) ? $result : null;
    }

    //fonction pour rérup description système; va retourner la déscription 
    public function getSysDescr() {
        $oid = '.1.3.6.1.2.1.1.1.0';
        $result = @snmp2_get($this->ip, $this->community, $oid, $this->timout, $this->retries);
        return ($result !== false) ? $result : null; 
    }
}