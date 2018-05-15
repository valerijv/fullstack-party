<?php

namespace App\Service;

use App\Service\Github;
use Github\Client;
use Carbon\Carbon;

class Issue
{
    private $githubApi;
    private $repoUser;
    private $repoName;

    public function __construct($repoUser, $repoName, Client $githubApi)
    {
        $this->githubApi = $githubApi;
        $this->repoUser = $repoUser;
        $this->repoName = $repoName;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('site/index.html.twig');
    }

    public function getIssues(int $page): array
    {
        $issues = $this->githubApi->api('issue')->all($this->repoUser, $this->repoName, [
            'page' => $page
        ]);
        $issues = $this->formatIssues($issues);
        return $issues;
    }

    public function formatIssues(array $issues): array
    {
        $formattedIssues = [];
        foreach ($issues as $issue) {
            $issue['human_date'] = Carbon::parse($issue['created_at'])->diffForHumans();
            $formattedIssues[] = $issue;
        }
        return $formattedIssues;
    }

    public function getIssuesCount(string $state): int
    {
        return $this->githubApi->api('search')
                ->issues(
                    'repo:' . $this->repoUser . '/' . $this->repoName . ' type:issue state:' . $state
                )['total_count'] ?? 0;
    }

    public function getIssue($number): array
    {
        return $this->githubApi->api('issue')->show($this->repoUser, $this->repoName, $number);
    }

}