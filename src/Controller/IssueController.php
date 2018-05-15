<?php

namespace App\Controller;

use App\Service\Issue;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IssueController extends Controller
{
    private $issue;

    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * @Route("/issues", name="issues")
     */
    public function issues(Request $request)
    {
        $issues = $this->issue->getIssues(
            (int)$request->get('page', 1)
        );
        return $this->json($issues);
    }

    /**
     * @Route("/issues-count", name="issues-count")
     */
    public function issuesCount()
    {
        return $this->json([
            'closed' => $this->issue->getIssuesCount('closed'),
            'open' => $this->issue->getIssuesCount('open')
        ]);
    }

    /**
     * @Route("/issue/{number}", name="issue")
     */
    public function issue($number)
    {
        $issues = $this->issue->getIssue($number);
        return $this->json($issues);
    }
}