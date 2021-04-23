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
    'modifier formation',
    'effacer formation',


    'matières premières',
    'crée matière première',
    'modifier matière première',
    'effacer matière première',

    'projet',
    'crée projet',
    'modifier projet',
    'effacer projet',

    'categories',
    'crée categorie',
    'modifier categorie',
    'effacer categorie',

    'gestion des pubs',
    'crée pub',
    'modifier pub',
    'effacer pub',
    
    'gestion des services',
    'crée service',
    'modifier service',
    'effacer service',

    'gestion des utilisateurs',
    'crées utilisateur',
    'modifier utilisateur',
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