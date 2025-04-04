<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Interactive Icon Examples</h2>
        
        <div class="control-panel-grid">
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Small Icon (100px)</h3>
                <div style="width: 100px; height: 100px;">
                    <x-interactive-icon size="100px" />
                </div>
            </div>
            
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Medium Icon (200px)</h3>
                <div style="width: 200px; height: 200px;">
                    <x-interactive-icon size="200px" />
                </div>
            </div>
            
            <div class="control-panel-card">
                <h3 class="control-panel-subtitle">Large Icon (300px)</h3>
                <div style="width: 300px; height: 300px;">
                    <x-interactive-icon size="300px" />
                </div>
            </div>
        </div>

        <div class="control-panel-card mt-8">
            <h2 class="control-panel-subtitle">Border Scale Examples</h2>
            <p class="mb-4">The borderScale parameter controls the thickness of borders relative to the icon size:</p>
            
            <div class="control-panel-grid">
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Thin Borders (0.05)</h3>
                    <div style="width: 200px; height: 200px;">
                        <x-interactive-icon size="200px" borderScale="0.05" />
                    </div>
                </div>
                
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Medium Borders (0.1)</h3>
                    <div style="width: 200px; height: 200px;">
                        <x-interactive-icon size="200px" borderScale="0.1" />
                    </div>
                </div>
                
                <div class="control-panel-card">
                    <h3 class="control-panel-subtitle">Thick Borders (0.15)</h3>
                    <div style="width: 200px; height: 200px;">
                        <x-interactive-icon size="200px" borderScale="0.15" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="control-panel-card mt-8">
            <h3 class="control-panel-subtitle">Fully Responsive Example</h3>
            <div style="width: 100%; max-width: 500px; aspect-ratio: 1/1;">
                <x-interactive-icon borderScale="0.08" />
            </div>
            <p class="mt-4">This example uses the full width of its container and scales with the page.</p>
        </div>
        
        <div class="control-panel-card mt-8">
            <h3 class="control-panel-subtitle">How to Use</h3>
            <p>You can add the interactive icon to any page using:</p>
            <pre><code>&lt;x-interactive-icon size="200px" /&gt;</code></pre>
            <p class="mt-4">Parameters:</p>
            <ul class="mt-2">
                <li><code>size</code> - Width and height of the icon (defaults to auto, which fills the container)</li>
                <li><code>borderScale</code> - Control border thickness as a proportion of square size (default: 0.1)</li>
            </ul>
            <p class="mt-4">Fully responsive example:</p>
            <pre><code>&lt;div style="width: 100%; max-width: 400px; aspect-ratio: 1/1;"&gt;
    &lt;x-interactive-icon /&gt;
&lt;/div&gt;</code></pre>
        </div>
    </div>
</x-control-panel-layout> 