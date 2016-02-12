<?php

namespace App\Services\Podcasts;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Collection;

class Search
{

    /**
     * @var bool
     */
    protected $corpusSearch;

    /**
     * @var String
     */
    protected $keyword;

    /**
     * @var Corpus
     */
    protected $corpus;

    /**
     * Search constructor.
     *
     * @param      $keyword
     * @param bool $corpusSearch
     */
    public function __construct($keyword, $corpusSearch = true)
    {
        $this->corpusSearch = $corpusSearch;
        $this->keyword = $keyword;
    }

    /**
     * @return array|mixed
     */
    public function search($keyword = null)
    {
        if ($keyword) {
            $search = new Search($keyword);
            return $search->search();
        }

        $result = [];
        if ($this->corpusSearch) {
            $result = $this->searchCorpus();
        }

        if (empty($result)) {
            $result = $this->searchFrameWork();
        }

        return $result;
    }

    /**
     * @return array
     */
    public function searchFrameWork()
    {
        return Podcast::where(Podcast::COLUMN_TRANSCRIPTION, 'LIKE', '%'.$this->keyword.'%')->get();
    }

    /**
     * @return mixed
     */
    public function searchCorpus()
    {
        return json_decode($this->getCorpus()->searchCorpus($this->keyword), true)['matches'];
    }

    /**
     * @return Corpus
     */
    protected function getCorpus()
    {
        if (!$this->corpus) {
            $this->corpus = new Corpus();
        }

        return $this->corpus;
    }

}
