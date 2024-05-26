<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Symfony\Component\DomCrawler\Crawler;

class ScrpController extends Controller
{
    public function scrape(Request $request)
    {
        // GuzzleHTTPクライアントを初期化
        $client = new Client();
        $base_url = 'https://pubmed.ncbi.nlm.nih.gov/';

        // ユーザー入力からキーワードとフィルターを取得
        $keywords = $request->input('keywords', '');
        $filter = $request->input('filter', '');
        $max_pages = 10;    // 最大ページ数を設定
        $articles = [];     // 記事データを格納する配列

        // キーワードが入力された場合のみ実行
        if (!empty($keywords)) {
            for ($page = 1; $page <= $max_pages; $page++) {
                // PubMedの検索URLを生成
                $url = "{$base_url}?term={$keywords}&filter={$filter}&page={$page}";
                // GETリクエストを送信
                $response = $client->request('GET', $url);
                // レスポンスのHTML内容を取得
                $html = $response->getBody()->getContents();

                // Crawlerを使ってHTMLをパース
                $crawler = new Crawler($html);
                $page_results = $crawler->filter('.docsum-content')->each(function (Crawler $node) {

                    // 各記事からタイトル、著者、PMID、要約、ジャーナル情報を抽出
                    return [
                        'title' => $node->filter('.docsum-title')->text(),
                        'authors' => $node->filter('.docsum-authors')->text(),
                        'pmid' => $node->filter('.docsum-pmid')->text(),
                        'snippet' => $node->filter('.full-view-snippet')->text(),
                        'journalCitation' => $node->filter('.docsum-journal-citation.full-journal-citation')->text()
                    ];
                });

                // 抽出した記事データを配列にマージ
                $articles = array_merge($articles, $page_results);
                // API制限やサーバーへの負荷を考慮して1秒待機
                sleep(1); 
            }
        }

        // ページネーションの設定
        // 配列をコレクションに変換
        $articles = collect($articles);
        // 現在のページ番号を取得
        $currentPage = $request->input('page', 1);
        // 1ページあたりの表示件数
        $perPage = 10;
        $currentItems = $articles->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedArticles = new LengthAwarePaginator($currentItems, count($articles), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // ビューにデータを渡す
        return view('pubmedScraping.index', compact('paginatedArticles', 'keywords'));
    }




    public function scrapetest()
    {
        // GuzzleHTTPクライアントを初期化
        $client = new Client();
        $url = 'https://iwasakigs.sakura.ne.jp/cheezeLp/';


                // GETリクエストを送信
                $response = $client->request('GET', $url);
                // レスポンスのHTML内容を取得
                // $html = $response->getBody()->getContents();
                $html = $response->getBody();

                // Crawlerを使ってHTMLをパース
                $crawler = new Crawler($html);
                $page_results = $crawler->filter('h3');

                // API制限やサーバーへの負荷を考慮して1秒待機
                sleep(1); 

                $htmls = [];
                foreach ($page_results as $page) {
                    $htmls[] = $page->textContent;
                }


        // ビューにデータを渡す
        return Inertia::render('Scrptest',['html'=>$htmls]);
    }

    public function scrapesumo()
    {
        $url = 'https://sports.yahoo.co.jp/sumo/torikumi/202405/14';

        // GuzzleHTTPを使用してページの内容を取得
        $client = new Client();
        $response = $client->request('GET', $url);

        $html = (string) $response->getBody();

        // Symfony Crawlerを使用してHTMLをパース
        $crawler = new Crawler($html);

        // 指定されたテーブルのデータを抽出
        $table = $crawler->filter('table.su-table.su-scoreTable');

        // テーブルが見つかったかどうかチェック
        if ($table->count() > 0) {
            $rows = $table->filter('tr')->each(function (Crawler $row, $i) {
                return $row->filter('td')->each(function (Crawler $cell, $j) {
                    // セルの中身が<span>タグの場合
                    if ($cell->filter('span')->count() > 0) {
                        $span = $cell->filter('span')->first();
                        $text = $span->text();
                        $ariaLabel = $span->attr('aria-label');
                        return $ariaLabel ?: $text; // aria-labelがあればそれを、なければテキストを返す
                    }

                    // その他の場合はテキストを返す
                    return $cell->text();
                });
            });

        // ビューにデータを渡す
        return Inertia::render('Scrptest',['html'=>$rows]);
        } else {
            return 'Table not found.';
        }
    }

}