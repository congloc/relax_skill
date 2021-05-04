<?php
namespace Modules\Location\Repositories;

use Illuminate\Http\Request;

use Modules\Location\Models\Skill;

class SkillRepository
{
    /**
     * Get data of province with pagination.
     *
     * @return Skill
     */
    public function getSkill()
    {
        return Skill::with(['id'])->get();
    }
}