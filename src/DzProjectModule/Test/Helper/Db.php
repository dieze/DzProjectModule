<?php

/**
 * Méthodes d'aide d'insertion de données
 * depuis les fichiers data/*.sql
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzProjectModule\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */

namespace DzProjectModule\Test\Helper;

/**
 * Méthodes d'aide d'insertion de données
 * depuis les fichiers data/*.sql
 *
 * @category Source
 * @package  DzProjectModule\Test\Helper
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/dieze/DzProjectModule
 */
class Db
{
    /**
     * Connection PDO
     * @var \PDO
     */
    protected $dbh;

    /**
     * Chemin vers le fichier de dump
     * @var string
     */
    protected $dumpFile;

    /**
     * Constructeur de Db
     *
     * @param \PDO $dbh Connection PDO
     *
     * @return void
     */
    public function __construct($dbh)
    {
        $this->dbh = $dbh;
        $this->dumpFile = __DIR__ . '/../../../../data/dzproject.dump.sqlite.sql';
    }

    /**
     * Insère les projets
     * dans la base de données
     *
     * @return void
     */
    public function insertProjects()
    {
        $sql = file_get_contents($this->getDumpFile());

        preg_match_all("/INSERT INTO '?project'? .*?;/s", $sql, $matches);
        $inserts = $matches[0];

        foreach ($inserts as $insert) {
            $this->dbh->exec($insert);
        }
    }

    /**
     * Exécute le fichier de dump
     *
     * @return void
     */
    public function execDumpFile()
    {
        $sql = file_get_contents($this->getDumpFile());

        $this->dbh->exec($sql);
    }

    /**
     * Obtient le chemin vers le fichier de dump
     *
     * @return string
     */
    public function getDumpFile()
    {
        return $this->dumpFile;
    }

    /**
     * Définit le chemin vers le fichier de dump
     *
     * @param string $dumpFile Nouveau chemin
     *
     * @return Db
     */
    public function setDumpFile($dumpFile)
    {
        $this->dumpFile = $dumpFile;

        return $this;
    }
}
