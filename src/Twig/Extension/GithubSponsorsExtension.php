<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig\Extension;

use App\Domain\Value\Repository;
use Github\Client as GithubClient;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GithubSponsorsExtension extends AbstractExtension
{
    private const WITH_SPONSOR_DASHBOARD = [
        'core23',
        'greg0ire',
        'OskarStark',
        'VincentLanglet',
        'wbloszyk',
        'jordisala1991',
    ];

    private GithubClient $github;

    public function __construct(GithubClient $github)
    {
        $this->github = $github;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('list_sponsorisable', [$this, 'listSponsorisable']),
        ];
    }

    /**
     * @return string[]
     */
    public function listSponsorisable(Repository $repository): array
    {
        $contributors = array_map(
            static fn (array $contributor): string => $contributor['login'],
            $this->github->repo()->contributors(
                $repository->username(),
                $repository->name(),
            )
        );

        return \array_slice(array_intersect($contributors, self::WITH_SPONSOR_DASHBOARD), 0, 4);
    }
}
