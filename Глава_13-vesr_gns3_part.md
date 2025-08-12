# Глава 13. [Настройка L2TPv3-туннелей](https://docs.eltex-co.ru/pages/viewpage.action?pageId=546144773#id-%D0%A3%D0%BF%D1%80%D0%B0%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5%D1%82%D1%83%D0%BD%D0%BD%D0%B5%D0%BB%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5%D0%BC-%D0%9D%D0%B0%D1%81%D1%82%D1%80%D0%BE%D0%B9%D0%BA%D0%B0L2TPv3-%D1%82%D1%83%D0%BD%D0%BD%D0%B5%D0%BB%D0%B5%D0%B9)

### Что такое протокол L2TPv3.

Среди множества типов VPN протокол l2tpv3 относится к протоколам типа
точка-точка и работает на втором уровне сетевой модели OSI:

![Рисунок 4-1. Cтруктурированная схема VPN-ов-
https://habrastorage.org/r/w1560/files/a6b/dc7/6da/a6bdc76dae4f4fa8967e2709d20b0ec2.png](Media/Рис13-1.png)

**L2TPv3 (Layer 2 Tunneling Protocol Version 3)** --- протокол
туннелирования, который поддерживает инкапсуляцию трафика второго уровня
(L2 модели OSI) поверх сетевого уровня
(L3). [ru.wikipedia.org](https://ru.wikipedia.org/wiki/L2TPv3)[faq.irz.net](https://faq.irz.net/routers/common/Primer_nastrojki_L2TPv3_tunnelya_dlya_routerov_iRZ.html)

**Спецификация**: RFC
3931. [ru.wikipedia.org](https://ru.wikipedia.org/wiki/L2TPv3)

**Применение**: L2TPv3 используется в корпоративных сетях для создания
виртуальных частных сетей и передачи данных между удалёнными офисами.
Также протокол может применяться как альтернатива многопротокольной
коммутации по меткам (MPLS) для организации VPN уровня
L2. [faq.irz.net](https://faq.irz.net/routers/common/Primer_nastrojki_L2TPv3_tunnelya_dlya_routerov_iRZ.html)[ru.wikipedia.org](https://ru.wikipedia.org/wiki/L2TPv3)

**Два режима работы**:

1.  **Поверх IP** --- использует IP-протокол L2TP (115). Используется,
    когда на пути передачи данных нет NAT или фаерволов.

2.  **Поверх UDP** --- использует IP-протокол UDP (17) с задаваемыми
    номерами портов. Предназначен для лучшей поддержки прохода NAT и
    фаерволов, поэтому его следует использовать, если в схеме есть
    устройства, выполняющие эти функции.

![Рисунок 4-2Рисунок 1. Cisco Network Architecture Diagram C4C ](Media/Рис13-2.jpg)

**Порядок работы**:

1.  Устройство в локальной сети передаёт на интерфейс L2TPv3
    маршрутизатора «А» пакеты канального уровня, которые нужно доставить
    до получателя в удалённой локальной сети.

2.  Маршрутизатор «А» на одном конце туннеля инкапсулирует пакет с
    данными в заголовок L2TPv3 и доставляет до интерфейса L2TPv3
    маршрутизатора «Б» на другом конце туннеля.

3.  Маршрутизатор «Б» декапсулирует пакет, снимает заголовок L2TPv3 и
    передаёт данные адресату в удалённой локальной сети.

 [fakel.io](https://fakel.io/docs/configuration/interfaces/l2tpv3/l2tpv3/)

<figure>
<img src="media/image3.jpeg" style="width:4.72441in;height:3.54357in"
alt="Picture background" />
<figcaption><p>Рисунок 4-3. <a
href="https://www.slideserve.com/melvin-logan/the-tcp-ip-model-powerpoint-ppt-presentation">PPT
- The TCP/IP Model</a></p></figcaption>
</figure>

**При этом внутри пакета происходит ещё одна магия инкапсуляции:**

![]
(Media/Рис13-2.jpg)
<figcaption><p>Рисунок 4-4. <a
href="https://studwood.net/1586304/informatika/shifrovanie_dannyh">Шифрование
Данных - Виртуальная частная сеть (VPN), технология, принципы
работы</a></p></figcaption>
</figure>

**Конфигурация**

**Для работы туннеля** на обоих маршрутизаторах должны быть настроены
интерфейсы L2TPv3. Некоторые параметры, которые нужно настроить:

- задать интерфейсу L2TPv3 локальный IP-адрес --- указанный адрес будет
  виден устройствам в локальной сети;

- задать IP-адрес источника и IP-адрес назначения --- интерфейсы L2TPv3
  на маршрутизаторах с двух концов туннеля будут использовать эти адреса
  для связи друг с другом.

 [fakel.io](https://fakel.io/docs/configuration/interfaces/l2tpv3/l2tpv3/)

**Туннели L2TPv3 относятся к типу «точка-точка»**. Оба участника туннеля
должны иметь внешние IP-адреса (или находиться в одной сети) и между
ними не должно быть трансляции адресов NAT (если в качестве транспорта
используется IP; при использовании UDP наличие NAT между точками
допускается). [faq.irz.net](https://faq.irz.net/routers/common/Primer_nastrojki_L2TPv3_tunnelya_dlya_routerov_iRZ.html)

**Безопасность**

**Протокол L2TPv3 не обеспечивает защищённость передаваемых по нему
данных**. Для обеспечения целостности и конфиденциальности данных
используется набор протоколов
IPSec. [habr.com](https://habr.com/ru/articles/246281/)[kb.numaedge.ru](https://kb.numaedge.ru/pptp-l2tp/protocols-description.html)

**Некоторые особенности безопасности**:

- **Идентификаторы сессии** --- используются на маршрутизаторе на другом
  конце туннеля для идентификации, к какому туннелю принадлежит
  конкретный пакет. Все полученные пакеты, принадлежащие к одному
  туннелю L2TPv3, должны иметь одинаковый идентификатор сессии.

- **Поле cookie** --- опциональное поле, которое обеспечивает гарантию,
  что полученный пакет принадлежит к сессии, идентифицированной
  идентификатором сессии. Это защищает от «атак на вставку пакетов».

 [fredrikjj.wordpress.com](https://fredrikjj.wordpress.com/2017/06/29/the-basics-of-l2tpv3/)

### Общая постановка задачи создания туннеля L2TPv3.

Настройка L2TPv3 (Layer 2 Tunneling Protocol Version 3) на сетевых
устройствах включает конфигурацию туннеля 2-го уровня (L2) через
IP-сеть. Это позволяет:

Транспортировать протоколы L2 (Ethernet, Frame-relay, ATM, HDLC, PPP и
др.) через IP-сеть.

Соединять удалённые сайты в одной подсети, если приложение требует,
чтобы хосты были в одном домене бродкастинга.

 [networklessons.com](https://networklessons.com/cisco/ccie-routing-switching-written/l2tpv3-layer-2-tunnel-protocol-version-3)

L2TPv3 --- стандарт IETF (RFC3931), который имеет отдельный номер
протокола (115) и сочетает технологии Cisco L2F (Layer 2 Forwarding) и
Microsoft Point to Point Tunneling Protocol
(PPTP). [networklessons.com](https://networklessons.com/cisco/ccie-routing-switching-written/l2tpv3-layer-2-tunnel-protocol-version-3)

**настройка протокола L2TPv3** (Layer 2 Tunneling Protocol (Version 3))
включает создание «псевдопроводного» туннеля между двумя пограничными
маршрутизаторами. Протокол функционирует на сетевом уровне модели OSI,
но инкапсулирует данные канального
уровня. [fakel.io](https://fakel.io/docs/configuration/interfaces/l2tpv3/l2tpv3/)[cisco.com](https://www.cisco.com/c/en/us/td/docs/routers/ios/config/17-x/lan-wan/b-lan-wan/m_wan-l2-tun-pro-v3-xe.html)[ntc-contact.by](https://ntc-contact.by/files/bas/instruction11_L2TPv3_-_IPsec.pdf)

**Принцип работы**: устройство в локальной сети передаёт на интерфейс
L2TPv3 маршрутизатора пакеты канального уровня, которые нужно доставить
до получателя в удалённой локальной сети. Маршрутизатор на одном конце
туннеля инкапсулирует пакет с данными в заголовок L2TPv3 и доставляет до
интерфейса L2TPv3 маршрутизатора на другом конце
туннеля. [fakel.io](https://fakel.io/docs/configuration/interfaces/l2tpv3/l2tpv3/)

**Требования**

Для работы туннеля на обоих маршрутизаторах должны быть настроены
интерфейсы L2TPv3. Также туннель должен принадлежать мосту, который
необходимо соединить с сетью
партнёра. [fakel.io](https://fakel.io/docs/configuration/interfaces/l2tpv3/l2tpv3/)[docs.eltex-co.ru](https://docs.eltex-co.ru/pages/viewpage.action?pageId=395772169)[docs.eltex-co.ru](https://docs.eltex-co.ru/pages/viewpage.action?pageId=55183533)

**Пошаговая инструкция**

Некоторые параметры, которые нужно настроить:

- **Локальный и удалённый шлюз** (IP-адреса интерфейсов, граничащих с
  WAN).

- **Тип инкапсулирующего протокола** и номера UDP-портов.

- **Идентификаторы сессии** внутри туннеля для локальной и удалённой
  сторон.

- **Принадлежность туннеля к мосту**.

- **Идентификаторы туннеля** на локальной и удалённой сторонах.

 [docs.eltex-co.ru](https://docs.eltex-co.ru/pages/viewpage.action?pageId=55183533)[docs.eltex-co.ru](https://docs.eltex-co.ru/pages/viewpage.action?pageId=395772169)

Опционально можно настроить, например:

- **Максимальный размер сегмента** при передаче пакетов по протоколу TCP
  (можно задать вручную или настроить автоматически).

**Ошибки и их решение**

Некоторые ошибки, которые могут возникнуть при настройке протокола
L2TPv3, и способы их решения:

- **Блокировка соединения брандмауэром**. Необходимо разрешить для
  L2TPv3-пакетов UDP-порт 555.

- **Некорректно указанный IP-адрес** L2TP-сервера на L2TP-клиенте.

Схема коммутации для выполнения этой работы:

![Рисунок 4-5. Схема связи офиса и филиала по туннелю
L2TPv3+IPSEC](Media/Рис13-5.png)

Конфигурация маршрутизатора, связующего офис и филиал и дающий выход в
интернет через провайдера точно такая же как и в предыдущих главах.

### Настройка маршрутизатора центрального офиса.

Базовые параметры для настройки включают : его внешний IP-адрес ---
10.10.10.2; Адрес локальной сети -- 172.16.1.0/24;\
Подключение филиала и его внешний IP-адрес --- 10.10.20.2;\
В качестве основы взят предварительно инициированный образ из первой
главы. Назначаем адреса на интерфейсы, задаем имя и создаем группы
объектов:

vesr# config

vesr124-2-2(config)# hostname vesr124-2-2

vesr124-2-2(config)#

vesr124-2-2(config)# object-group service dhcp_service

vesr124-2-2(config-object-group-service)# port-range 67

vesr124-2-2(config-object-group-service)# exit

vesr124-2-2(config)# object-group service dhcp_client

vesr124-2-2(config-object-group-service)# port-range 68

vesr124-2-2(config-object-group-service)# exit

vesr124-2-2(config)# object-group service L2TPV3

vesr124-2-2(config-object-group-service)# port-range 555

vesr124-2-2(config-object-group-service)# exit

vesr124-2-2(config)# object-group service NTP

vesr124-2-2(config-object-group-service)# port-range 123

vesr124-2-2(config-object-group-service)# exit

vesr124-2-2(config)# object-group service DNS

vesr124-2-2(config-object-group-service)# port-range 53

vesr124-2-2(config-object-group-service)# exit

vesr124-2-2(config)# object-group service IKE

vesr124-2-2(config-object-group-service)# port-range 500

vesr124-2-2(config-object-group-service)# port-range 4500

vesr124-2-2(config-object-group-service)# exit

// созданы группы объектов для служб точного времени, имен и IPSEC

vesr124-2-2(config)#

vesr124-2-2(config)# object-group network WAN

vesr124-2-2(config-object-group-network)# ip address-range 10.10.10.2

vesr124-2-2(config-object-group-network)# exit

vesr124-2-2(config)# object-group network LAN_NETWORK

vesr124-2-2(config-object-group-network)# ip address-range
172.16.1.1-172.16.1

.254

vesr124-2-2(config-object-group-network)# exit

vesr124-2-2(config)# object-group network LAN_GW

vesr124-2-2(config-object-group-network)# ip address-range 172.16.1.1

vesr124-2-2(config-object-group-network)# exit

vesr124-2-2(config)#

// созданы группы сетевых объектов, определяющих локальную сеть,
дефолтные адреса для маршрутов в интернет и для локальной сети

Настраиваем зоны для пропуска пакетов и включаем преобразование адресов
в имена :

domain lookup enable

security zone TRUST

exit

security zone UNTRUST

exit

Для контроля работ понадобится свободный проход пакетов icmp.

vesr124-2-2(config)# security zone-pair TRUST self

vesr124-2-2(config-security-zone-pair)# rule 1

vesr124-2-2(config-security-zone-pair-rule)# description \"ICMP\"

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol icmp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

пакетов для запросов к серверам имен DNS:

vesr124-2-2(config-security-zone-pair)# rule 19

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup DNS

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

пакетов в туннель:

vesr124-2-2(config-security-zone-pair)# rule 20

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup L2TPV3

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

пакетов для запросов к серверам точного времени:

vesr124-2-2(config-security-zone-pair)# rule 30

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup NTP

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

пакетов для запросов к серверам выдачи адресов DHCP:

vesr124-2-2(config-security-zone-pair)# rule 40

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match source-port
object-group

dhcp_client

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup dhcp_service

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 50

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol tcp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# exit

vesr124-2-2(config)# security zone-pair TRUST UNTRUST

vesr124-2-2(config-security-zone-pair)# rule 10

vesr124-2-2(config-security-zone-pair-rule)# description \"ICMP\"

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol icmp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 20

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 30

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol tcp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# exit

vesr124-2-2(config)# security zone-pair UNTRUST self

vesr124-2-2(config-security-zone-pair)# rule 10

vesr124-2-2(config-security-zone-pair-rule)# description \"ICMP\"

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol icmp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 18

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol tcp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup DNS

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 19

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup DNS

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 20

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup L2TPV3

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 30

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup NTP

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

Для шифрования пакетов в туннеле понадобится свободный проход пакетов
IPSEC.

vesr124-2-2(config-security-zone-pair)# rule 35

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol udp

vesr124-2-2(config-security-zone-pair-rule)# match destination-port
object-g

roup IKE

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 40

vesr124-2-2(config-security-zone-pair-rule)# description \"ESP\"

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol esp

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# rule 50

vesr124-2-2(config-security-zone-pair-rule)# description \"AH\"

vesr124-2-2(config-security-zone-pair-rule)# action permit

vesr124-2-2(config-security-zone-pair-rule)# match protocol ah

vesr124-2-2(config-security-zone-pair-rule)# enable

vesr124-2-2(config-security-zone-pair-rule)# exit

vesr124-2-2(config-security-zone-pair)# exit

vesr124-2-2(config)#

Полный текст главы 13 на Бусти - [![Кнопка доната](https://img.shields.io/badge/Загрузить_текст_с-Boosty-6c5ce7)](https://boosty.to/rinatxf/posts/67337003-b899-4c52-a58b-65f7c6817a09)


### Сводка или ключевые выводы главы 

- В этой главе вы кратко ознакомились с протоколом L2TPv3.

- Приведено применение этого протокола на практике.

- Приведен перечень команд для настройки туннеля и его шифрации в сети
  интернет и проверки маршрутизации в туннеле между узлами сети.

- Создан полноценныq L2TPv3-VPN туннель для связности центрального узла
  сети и филиал между собой.

- Приведены команды проверки и поиска возможных неисправностей в работе
  туннелей.

- В конце главы приведены полные конфигурационные настройки для
  рассматриваемой работы.

- В следующей главе вы узнаете как настраивается VTI туннель.
