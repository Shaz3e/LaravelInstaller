<?php

namespace Shaz3e\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Shaz3e\LaravelInstaller\Events\LaravelInstallerFinished;
use Shaz3e\LaravelInstaller\Helpers\EnvironmentManager;
use Shaz3e\LaravelInstaller\Helpers\FinalInstallManager;
use Shaz3e\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Shaz3e\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Shaz3e\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Shaz3e\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
