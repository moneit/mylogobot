<input type="checkbox" id="preview-toggle" />

<label for="preview-toggle" class="overlay"></label>

<div id="logo-previews-wrapper" class="logo-preview-wrapper rounded">
    <div class="container-fluid overflow-hidden">
        <div class="row">
            <div class="col-md-6">
                <div class="preview preview-cards" :style="{ backgroundColor: previewSettings.settings.backgroundColor ? previewSettings.settings.backgroundColor.hex : 'transparent' }">
                    <div class="logo-container">
                        <div class="overflow-hidden">
                            <logo-preview-wrapper
                                    :preview-settings="previewSettings"
                                    :show-background="false"
                                    :compact="true"
                            ></logo-preview-wrapper>
                        </div>
                    </div>
                    <div class="logo-container">
                        <div class="overflow-hidden">
                            <logo-preview-wrapper
                                    :preview-settings="previewSettings"
                                    :show-background="false"
                                    :compact="true"
                            ></logo-preview-wrapper>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="preview preview-t-shirt" :style="{ backgroundColor: previewSettings.settings.backgroundColor ? previewSettings.settings.backgroundColor.hex : 'transparent' }">
                    <div class="logo-container">
                        <div class="overflow-hidden">
                            <logo-preview-wrapper
                                    :preview-settings="previewSettings"
                                    :show-background="false"
                                    :compact="true"
                            ></logo-preview-wrapper>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="preview preview-cup" :style="{ backgroundColor: previewSettings.settings.backgroundColor ? previewSettings.settings.backgroundColor.hex : 'transparent' }">
                    <div class="logo-container">
                        <div class="overflow-hidden">
                            <logo-preview-wrapper
                                    :preview-settings="previewSettings"
                                    :show-background="false"
                                    :compact="true"
                            ></logo-preview-wrapper>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="preview preview-billboard" :style="{ backgroundColor: previewSettings.settings.backgroundColor ? previewSettings.settings.backgroundColor.hex : 'transparent' }">
                    <div class="logo-container">
                        <div class="overflow-hidden">
                            <logo-preview-wrapper
                                    :preview-settings="previewSettings"
                                    :show-background="false"
                                    :compact="true"
                            ></logo-preview-wrapper>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <label for="preview-toggle" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </label>
    </div>
</div>