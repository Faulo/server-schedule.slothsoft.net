<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns="http://schema.slothsoft.net/farah/sitemap"
	xmlns:sfd="http://schema.slothsoft.net/farah/dictionary"
	xmlns:sfm="http://schema.slothsoft.net/farah/module"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="/*">
		<domain name="schedule.slothsoft.net" vendor="slothsoft"
			module="schedule.slothsoft.net" ref="pages/index" status-active=""
			status-public="" sfd:languages="de-de en-us" version="1.1">
            <page name="cron" title="cron" ref="data/cron" status-active=""/>
			<page name="sitemap" ref="//slothsoft@farah/sitemap-generator"
				status-active="" />
		</domain>
	</xsl:template>
</xsl:stylesheet>
				