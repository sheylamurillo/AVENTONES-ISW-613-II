<?php

namespace App\Models;

use CodeIgniter\Model;


class ReportModel extends Model
{
    protected $table = 'search_report';
    protected $primaryKey = 'id';

    protected $allowedFields = [ 
        'idUser', 'origin', 'destination', 'results_count', 'search_date'
    ];


    //Inserta los siguientes datos en la tabla: origen,destino y  usuario quien realizó la búsqueda
    public function insertSearch($data)
    {
        return $this->insert($data, true);
    }

     public function updateSearchUser($id, $userId)
    {
        return $this->update($id, [
            'idUser' => $userId
        ]);
    }
    //Obtiene los datos de las búsquedas realizas por los usuarios  de acuerdo a un rango de rechas
    public function getSearchResultByDate($date1,$date2)
    {
        return $this->select('u.ID, u.name , u.lastName, search_report.origin,search_report.destination,search_report.results_count, search_report.search_date')
                    ->join('users u', 'search_report.idUser = u.idUser', 'left')
                    ->where('search_report.search_date >=',$date1)
                    ->where('search_report.search_date <=',$date2)
                    ->orderBy('search_report.search_date', 'DESC')
                    ->findAll();
    }
    
}
