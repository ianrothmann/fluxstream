<div>
    <flux:sidebar sticky
                  stashable
                  class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700"
    >
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

        <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc." class="px-2 dark:hidden"/>
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
                    class="px-2 hidden dark:flex"/>

        <flux:input as="button" variant="filled" placeholder="Search..." icon="magnifying-glass"/>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="/">Home</flux:navlist.item>
            <flux:navlist.item icon="face-smile" href="/playground">Playground</flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>
</div>
