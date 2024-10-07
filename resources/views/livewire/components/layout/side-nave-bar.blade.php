<div>
    <flux:sidebar stashable sticky
                  class="border-r lg:hidden bg-zinc-50 border-zinc-200">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

        <flux:brand href="/" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
                    class="px-2"/>
        <flux:brand href="/" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
                    class="hidden px-2"/>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="/">Home</flux:navlist.item>
            <flux:navlist.item icon="face-smile" href="/playground">Playground</flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>
</div>
