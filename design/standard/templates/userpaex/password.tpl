{* DO NOT EDIT THIS FILE! Use an override template instead. *}

<div class="border-box"><div class="tl"><div class="tr"><div class="br"><div class="bl"><div class="box-content float-break">
	<div class="border-ml"><div class="border-mr"><div class="border-mc">

<form action={concat($module.functions.password.uri,"/",$userID)|ezurl} method="post" name="Password">

    <div class="maincontentheader">
        <h1>{"Change password for user"|i18n("mbpaex/userpaex")}</h1>
    </div>
    
    {if $message}
        {if or($oldPasswordNotValid,$newPasswordNotMatch,$newPasswordNotValidate,$newPasswordMustDiffer)}
            {if $oldPasswordNotValid}
                <div class="warning">
                    <h2>{'Please retype your old password.'|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}
            {if $newPasswordNotMatch}
                <div class="warning">
                    <h2>{"Password didn't match, please retype your new password."|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}
            {if $newPasswordNotValidate}
                <div class="warning">
                    {if and(is_set($newPasswordValidationMessage), $newPasswordValidationMessage|ne(''))}
                        <h2>{$newPasswordValidationMessage}</h2>
                    {else}
                        <h2>{"Password didn't validate, please retype your new password."|i18n('mbpaex/userpaex')}</h2>
                    {/if}
                </div>
            {/if}
            {if $newPasswordMustDiffer}
                <div class="warning">
                    <h2>{"New password must be different from the old one. Please choose another password."|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}                    
        {else}
            <div class="feedback">
                <h2>{'Password successfully updated.'|i18n('mbpaex/userpaex')}</h2>
            </div>
        {/if}
    {/if}
    
    <div class="block">
        {if $oldPasswordNotValid}*{/if}
        <label>{"Old password"|i18n("mbpaex/userpaex")}</label><div class="labelbreak"></div>
        <input type="password" name="oldPassword" size="11" value="{$oldPassword}" />
    </div>
    
    <div class="block">
        <div class="element">
            {if or($newPasswordNotMatch,$newPasswordNotValidate)}*{/if}
            <label>{"New password"|i18n("mbpaex/userpaex")}</label><div class="labelbreak"></div>
            <input type="password" name="newPassword" size="11" value="{$newPassword}" />
        </div>
        <div class="element">
            {if or($newPasswordNotMatch,$newPasswordNotValidate)}*{/if}
            <label>{"Retype password"|i18n("mbpaex/userpaex")}</label><div class="labelbreak"></div>
            <input type="password" name="confirmPassword" size="11" value="{$confirmPassword}" />
        </div>
        <div class="break"></div>
    </div>
    
    <div class="buttonblock">
        <input class="defaultbutton" type="submit" name="OKButton" value="{'OK'|i18n('mbpaex/userpaex')}" />
        <input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n('mbpaex/userpaex')}" />
    </div>

</form>

</div></div></div>
</div></div></div></div></div></div>
