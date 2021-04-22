<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$permissions = [
    'accès au tableau de bord',
    'machines',
    'toutes les machine',
    'requetes des machines en attend',
    'nouvelles machines',
    'machines occasions',
    'crée machine',
    'modifier machine',
    'effacer machine',
    'accept machine',
    'rejeter machine',


    'formations',
    'crée formation',
    'modfier formation',
    'effacer formation',


    'matières premières',
    'crée matière première',
    'modfier matière première',
    'effacer matière première',

    'categories',
    'crée categorie',
    'modifer categorie',
    'effacer categorie',

    'gestion des pubs',
    'crée pub',
    'modifer pub',
    'effacer pub',
    
    'gestion des services',
    'crée service',
    'modifer service',
    'effacer service',

    'gestion des utilisateurs',
    'crées utilisateur',
    'mofider utilisateur',
    'supprimer utilisateur',

    'gestion des roles',
    'crée role',
    'modifier  role',
    'supprimer role',

    'Aucune',

];
foreach ($permissions as $permission) {
Permission::create(['name' => $permission]);
}
}
}