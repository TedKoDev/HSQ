<?php
// This file was auto-generated from sdk-root/src/data/dataexchange/2017-07-25/endpoint-tests-1.json
return [ 'testCases' => [ [ 'documentation' => 'For region eu-central-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.eu-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'eu-central-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.eu-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'eu-central-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.eu-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'eu-central-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region eu-central-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.eu-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'eu-central-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-west-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-west-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-west-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-west-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-west-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-west-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-west-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-west-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-west-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-west-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-west-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-west-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.eu-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'eu-west-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.eu-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'eu-west-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.eu-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'eu-west-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region eu-west-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.eu-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'eu-west-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.eu-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'eu-west-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.eu-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'eu-west-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.eu-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'eu-west-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region eu-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.eu-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'eu-west-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-northeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-northeast-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-northeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-northeast-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-northeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-northeast-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-northeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-northeast-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-northeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-northeast-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-northeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-northeast-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-northeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-northeast-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-northeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-northeast-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-southeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-southeast-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-southeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-southeast-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-southeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-southeast-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-southeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-southeast-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-southeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-southeast-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.ap-southeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-southeast-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-southeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'ap-southeast-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.ap-southeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'ap-southeast-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-east-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-east-1', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-east-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-east-1', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-east-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-east-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-east-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-east-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange-fips.us-east-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-east-2', 'UseFIPS' => true, ], ], [ 'documentation' => 'For region us-east-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-east-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-east-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For region us-east-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://dataexchange.us-east-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-east-2', 'UseFIPS' => false, ], ], [ 'documentation' => 'For custom endpoint with fips disabled and dualstack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://example.com', ], ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-east-1', 'UseFIPS' => false, 'Endpoint' => 'https://example.com', ], ], [ 'documentation' => 'For custom endpoint with fips enabled and dualstack disabled', 'expect' => [ 'error' => 'Invalid Configuration: FIPS and custom endpoint are not supported', ], 'params' => [ 'UseDualStack' => false, 'Region' => 'us-east-1', 'UseFIPS' => true, 'Endpoint' => 'https://example.com', ], ], [ 'documentation' => 'For custom endpoint with fips disabled and dualstack enabled', 'expect' => [ 'error' => 'Invalid Configuration: Dualstack and custom endpoint are not supported', ], 'params' => [ 'UseDualStack' => true, 'Region' => 'us-east-1', 'UseFIPS' => false, 'Endpoint' => 'https://example.com', ], ], ], 'version' => '1.0',];
