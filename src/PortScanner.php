<?php
class PortScanner {
    private int $timeout;

    public function __construct(int $timeout = 1) {
        $this->timeout = $timeout;
    }

    public function scanSingle(string $ip, int $port): array {
        return $this->checkPort($ip, $port);
    }

    public function scanRange(string $ip, int $start, int $end): array {
        $results = [];
        for ($port = $start; $port <= $end; $port++) {
            $results[] = $this->checkPort($ip, $port);
        }
        return $results;
    }

    private function checkPort(string $ip, int $port): array {
        $conn = @fsockopen($ip, $port, $errno, $errstr, $this->timeout);
        if ($conn) {
            fclose($conn);
            $statut = 'open';
        } else {
            $statut = ($errno === 111) ? 'closed' : 'filtered';
        }
        return [
            'port'    => $port,
            'statut'  => $statut,
            'service' => $this->getServiceName($port),
        ];
    }

    private function getServiceName(int $port): string {
        $services = [
            21 => 'FTP', 22 => 'SSH', 23 => 'Telnet', 25 => 'SMTP',
            80 => 'HTTP', 110 => 'POP3', 143 => 'IMAP', 443 => 'HTTPS',
            3306 => 'MySQL', 3389 => 'RDP', 5432 => 'PostgreSQL', 8080 => 'HTTP-Alt'
        ];
        return $services[$port] ?? '';
    }
}