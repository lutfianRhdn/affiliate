<?php


// namespace App\Helpers;

use App\Models\Company;
use App\Models\LogActivity as ModelsLogActivity;



    function addToLog($subject, $companyId =null)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['user_id'] = auth()->check() ? auth()->user()->id : null ;
        $log['company_id']= $companyId;   
        if ( auth()->check() ?(!auth()->user()->hasRole('super-admin')):false) {
            $log['company_id']= getCompanyId();
        }
        ModelsLogActivity::create($log);
    }

    function getRoleName($router){
        $routes = collect($router)->map(function ($route){
            return $route->getName();
        });
        $router =[];
        foreach ($routes as $route ) {
            if(strpos($route,'admin.',0) !== false){
                if(strpos($route,'.index') !== false){
                    $removeAdminUrl= str_replace('admin.','',$route);
                    $urlName = str_replace('.index','',$removeAdminUrl);
                    // add management word in role,company,product,user 
                    if ($urlName== 'user') {
                        $urlName = ['company','admin','reseller'];
                    }
                    
                    array_push($router,$urlName  );
                }
            }
        }
        $keyReseller = array_search('reseller',$router);
        $keyCompany = array_search('company',$router);
        unset($router[$keyCompany]);
        unset($router[$keyReseller]);
        return $router;
    }

    function filterData($models){
        $data= $models::where('company_id',null)->get();
        // $data= $models::all();
        if (!auth()->user()->hasRole('super-admin') && auth()->user()->company !== null) {
            $data = $models::where('company_id',auth()->user()->company->id)->get();
        }
        return $data;
    }
    function getCompanyId($companyId = null){
            if ($companyId !==null) {
               return $companyId;
            }
            if (auth()->check() ==true ? auth()->user()->hasRole('super-admin'): false) {
                return null;
            }
            if (auth()->check() == false ? true : auth()->user()->company == null ) {
                return null;
            }
        return auth()->user()->company->id;
    }
    function getAllCompanies()
    {
        return Company::all();
    }