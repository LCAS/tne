<?php

namespace App\Http\Controllers;

use App\Country;
use App\Criteria;
use App\Module;
use App\Programme;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function store(Country $country, Programme $programme, Module $module)
    {
        request()->validate(['description' => 'required']);
        $module->criterias()->save(Criteria::make(['description' => request()->description]));
        $criterias = $module->criterias()->orderBy('description')->get();

        return redirect()->route('countries.programmes.modules.show',
            compact('country', 'programme', 'module', 'criterias'))
            ->with('flash', request()->name.' successfully created');
    }

    public function update(Country $country,
        Programme $programme, Module $module, Criteria $criteria)
    {
        request()->validate(['description' => 'required']);

        return tap($criteria)->update(request()->only('description'));
    }

    public function addLink(Country $country,
        Programme $programme, Module $module, Criteria $criteria)
    {
        return $criteria->add_link(request()->link_id)->find(request()->link_id);
    }

    public function removeLink(Country $country,
        Programme $programme, Module $module, Criteria $criteria, $link_id)
    {
        return $criteria->remove_link($link_id);
    }

    public function destroy(Country $country, Programme $programme, Module $module, Criteria $criteria)
    {
        $criteria->remove_links()->delete();
    }
}
