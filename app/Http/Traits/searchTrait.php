<?php
/**
 * Created by PhpStorm.
 * User: MDIT
 * Date: 23-Oct-18
 * Time: 5:48 PM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\DB;

trait searchTrait
{

    public function getDataBySearchQuery($query,$modelType=null)
    {


        if (request()->input('category')) {
            $this->filterCategories($query);

        };
        if (request()->input('manufacturer')) {
            $this->filterManufacturer($query);

        };
        if (request()->input('type')) {
            $this->filterType($query);

        };
        if (request()->input('model')) {
            $this->filterModel($query);
        };


        if (request()->input('offer_for')) {
            $this->filterOfferFor($query,$modelType);
        }
        if (request()->input('status')) {
            $this->filterStatus($query,$modelType);
        }

        if (request()->input('asset_type')) {
            $this->filterAssetType($query);
        }
        if (request()->input('airfield_type')) {
            $this->filterAirFiedlType($query);
        }
        if (request()->input('job_title')) {
            $this->filterJobTitle($query);
        }
        return $query;
    }



    public function searchTitle($query)
    {
        $query->where('title', 'LIKE', '%' . request()->input('title') . '%');
    }

    private function filterJobTitle($query){
        $query->where(function ($query){
            foreach (request()->input('job_title') as $key => $value) {
                if ($key == 0) {
                    $query->where('job_title', $value);
                } else {
                    $query->orWhere('job_title', $value);
                }
            }
        });
    }

    private function filterAssetType($query){
        $query->where(function ($query){
            foreach (request()->input('asset_type') as $key => $value) {
                if ($key == 0) {
                    $query->where('type', $value);
                } else {
                    $query->orWhere('type', $value);
                }
            }
        });
    }
    private function filterAirFiedlType($query){
        $query->where(function ($query){
            foreach (request()->input('airfield_type') as $key => $value) {
                if ($key == 0) {
                    $query->where('airports.airfield_type_id', $value);
                } else {
                    $query->orWhere('airports.airfield_type_id', $value);
                }
            }
        });
    }
    private function filterOfferFor($query,$modelType)
    {
        $query->where(function ($query)use($modelType) {
            $modelType=='wanted'?$searchField='terms':$searchField='offer_for';
            foreach (request()->input('offer_for') as $key => $value) {
                if ($key == 0) {
                    $query->where($searchField, $value);
                } else {
                    $query->orWhere($searchField, $value);
                }
            }
        });
    }

    private function filterStatus($query,$modelType=null)
    {

        $query->where(function ($query)use($modelType) {
            foreach (request()->input('status') as $key => $value) {
                if ($key == 0) {
                    $query->where('status', $value);
                } else {
                    $query->orWhere('status', $value);
                }
            }
        });
    }

    private function filterCategories($query)
    {
        $query->where(function ($query) {
            foreach (request()->input('category') as $key => $value) {
                if ($key == 0) {
                    $query->where('category_id', $value);
                } else {
                    $query->orWhere('category_id', $value);
                }
            }
        });

    }

    /**
     * @param $query
     * @return array
     */
    private function filterManufacturer($query)
    {
        $query->where(function ($query) {
            foreach (request()->input('manufacturer') as $key => $value) {
                if ($key == 0) {
                    $query->where('manufacturer_id', $value);
                } else {
                    $query->orWhere('manufacturer_id', $value);
                }
            }
        });
    }

    /**
     * @param $query
     * @return array
     */
    private function filterType($query)
    {
        $query->where(function ($query) {
            foreach (request()->input('type') as $key => $value) {
                if ($key == 0) {
                    $query->where('type_id', $value);
                } else {
                    $query->orWhere('type_id', $value);
                }
            }
        });
    }

    /**
     * @param $query
     */
    private function filterModel($query)
    {
        $query->where(function ($query) {
            foreach (request()->input('model') as $key => $value) {
                if ($key == 0) {
                    $query->where('model_id', $value);
                } else {
                    $query->orWhere('model_id', $value);
                }
            }
        });
    }

    public function filterCategoriesForJoinData($query,$table)
    {
        $query->where(function ($query) use($table) {
            foreach (request()->input('category') as $key => $value) {

                if ($key == 0) {
                    $query->where($table.'.category_id', $value);
                } else {
                    $query->orWhere($table.'.category_id', $value);
                }
            }
        });


    }

    public function filterRegion($query,$table)
    {
        $query->where(function ($query) use($table) {
            foreach (request()->input('region') as $key => $value) {
                if ($key == 0) {
                    $query->where($table.'.region_id', $value);
                } else {
                    $query->orWhere($table.'.region_id', $value);
                }
            }
        });
    }

    public function filterCountry($query,$table=null)
    {
        $query->where(function ($query) use($table) {
            if($table==null){
                foreach (request()->input('country') as $key => $value) {
                    if ($key == 0) {
                        $query->where('country_id', $value);
                    } else {
                        $query->orWhere('country_id', $value);
                    }
                }
            }

            else{
                foreach (request()->input('country') as $key => $value) {
                    if ($key == 0) {
                        $query->where($table.'.country_id', $value);
                    } else {
                        $query->orWhere($table.'.country_id', $value);
                    }
                }
            }

        });

    }

    public function filterSpeciality($query,$table=null)
    {
        $query->where(function ($query) use($table) {
                foreach (request()->input('speciality') as $key => $value) {
                    if ($key == 0) {
                        $query->where($table.'.speciality_id', $value);
                    } else {
                        $query->orWhere($table.'.speciality_id', $value);
                    }
                }
        });

    }

    public function filterLocationUsingCountry($query)
    {
        $query->where(function ($query){
            foreach (request()->input('country') as $key => $value) {
                if ($key == 0) {
                    $query->where('location', $value);
                } else {
                    $query->orWhere('location', $value);
                }
            }
        });
    }


    public function filterCondition($query)
    {
        $query->where(function ($query){
            foreach (request()->input('condition') as $key => $value) {
                if ($key == 0) {
                    $query->where('condition_id', $value);
                } else {
                    $query->orWhere('condition_id', $value);
                }
            }
        });
    }
}