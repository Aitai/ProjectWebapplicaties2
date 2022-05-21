<?php

namespace Tests;


class Test extends TestCase
{

    /**
     * All acties voor klanten van de weather app
     * @return void
     */

    public function testCreateAsAuthenticated(){}
    public function testCreateInvalidedAsAuthenticated(){}
    public function testUpdateAsAuthenticated(){}
    public function testUpdateInvalidedAsAuthenticated(){}
    public function testDeleteAsAuthenticated(){}
    public function testShowAsAuthenticated(){}
    public function testRestoreAsAuthenticated(){}
    public function testForceDeleteAsAuthenticated(){}

    /**
     * Alle acties als gebruiker met rechten als maintenance
     */

    public function testCreateAsMaintenance(){}
    public function testCreateInvalidedAsMaintenance(){}
    public function testUpdateAsMaintenance(){}
    public function testUpdateInvalidedAsMaintenance(){}
    public function testDeleteAsMaintenance(){}
    public function testShowAsMaintenance(){}
    public function testRestoreAsMaintenance(){}
    public function testForceDeleteAsMaintenance(){}

    /**
     * deze acties mogen alleen door de eigenaar of een administrator uitgevoerd worden
     */
    public function testUpdateAsOwner(){}
    public function testUpdateInvalidedAsOwner(){}
    public function testDeleteAsOwner(){}
    public function testShowAsOwner(){}

    /**
     * de administrator moet alle acties kunnen uitvoeren
     */

    public function testCreateAsAdmin(){}
    public function testCreateInvalidedAsAdmin(){}
    public function testUpdateAsAdmin(){}
    public function testUpdateInvalidedAsAdmin(){}
    public function testDeleteAsAdmin(){}
    public function testShowAsAdmin(){}
    public function testRestoreAsAdmin(){}
    public function testForceDeleteAsAdmin(){}
}
