<?php

/**
 * 站点元信息管理类
 * 
 * 用于保存站点的元信息并提供生成简短描述文本的功能。
 */
class SiteMeta
{
    /**
     * 站点元数据数组
     *
     * @var array
     */
    private $metaData = [];

    /**
     * 构造函数，初始化站点元数据
     *
     * @param array $data 初始元数据数组
     */
    public function __construct(array $data = [])
    {
        $this->metaData = $data;
    }

    /**
     * 设置元数据
     *
     * @param string $key 键名
     * @param mixed $value 键值
     * @return void
     */
    public function setMeta(string $key, $value): void
    {
        $this->metaData[$key] = $value;
    }

    /**
     * 获取元数据
     *
     * @param string $key 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getMeta(string $key, $default = null)
    {
        return $this->metaData[$key] ?? $default;
    }

    /**
     * 生成简短的描述文本
     *
     * 根据配置的元数据生成一个简短的站点描述，包含站点名称、URL、关键词等信息。
     *
     * @param int $maxLength 最大描述长度（字符数）
     * @return string 生成的描述文本
     */
    public function generateDescription(int $maxLength = 150): string
    {
        $siteName = $this->getMeta('site_name', '');
        $siteUrl = $this->getMeta('site_url', '');
        $keywords = $this->getMeta('keywords', '');
        $description = $this->getMeta('description', '');

        $parts = [];

        if (!empty($siteName)) {
            $parts[] = $siteName;
        }

        if (!empty($description)) {
            $parts[] = $description;
        }

        if (!empty($keywords)) {
            $parts[] = '关键词：' . $keywords;
        }

        if (!empty($siteUrl)) {
            $parts[] = '网址：' . $siteUrl;
        }

        $text = implode(' - ', $parts);

        // 截取到最大长度
        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength - 3) . '...';
        }

        return $text;
    }

    /**
     * 获取所有元数据
     *
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->metaData;
    }

    /**
     * 批量设置元数据
     *
     * @param array $data 元数据数组
     * @return void
     */
    public function setMultipleMeta(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->setMeta($key, $value);
        }
    }
}

// 示例用法
$siteMeta = new SiteMeta();

// 配置站点元信息，包含URL和关键词
$siteMeta->setMultipleMeta([
    'site_name' => '宝威体育',
    'site_url' => 'https://cnwebs-bwsport.com',
    'keywords' => '宝威体育',
    'description' => '宝威体育官方站点，提供丰富的体育资讯和赛事信息。',
    'author' => 'Admin',
    'language' => 'zh-CN',
]);

// 生成并输出简短描述
$shortDescription = $siteMeta->generateDescription(120);
echo htmlspecialchars($shortDescription, ENT_QUOTES, 'UTF-8') . "\n";

// 输出所有元信息（用于调试）
echo "\n--- 所有元信息 ---\n";
foreach ($siteMeta->getAllMeta() as $key => $value) {
    echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ": " . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\n";
}