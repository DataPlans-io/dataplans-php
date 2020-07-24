<?php
class DataPlansPurchase extends DataPlansApiResource
{
    const ENDPOINT = 'purchases';

    /**
     * Retrieves a plan.
     *
     * @param  string $id
     * @param  string $token
     *
     * @return DataPlansPurchase
     */
    public static function retrieve($id = '')
    {
        return parent::doRetrieve(get_class(), self::getUrl($id));
    }

    /**
     * Creates a transfer.
     *
     * @param  mixed  $params
     *
     * @return DataPlansPurchase
     */
    public static function create($params)
    {
        return parent::doCreate(get_class(), self::getUrl(), $params);
    }

    /**
     * Reload a plan request
     *
     * @see DataPlansApiResource::doReload()
     */
    public function reload()
    {
        $id = empty($this['purchaseId']) ? '' : $this['purchaseId'];
        parent::doReload(self::getUrl($id));
    }

    /**
     * Returns endpoint url
     *
     * @param  string $slug
     * @return string
     */
    public static function getUrl($id = '')
    {
        return parent::getApiUrl(self::ENDPOINT.'/'.$id);
    }
}
